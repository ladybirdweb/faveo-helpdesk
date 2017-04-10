<?php

use Chumper\Zipper\Zipper;
use Illuminate\Filesystem\Filesystem;

require_once 'ArrayArchive.php';

class ZipperTest extends PHPUnit_Framework_TestCase
{


    /**
     * @var \Chumper\Zipper\Zipper
     */
    public $archive;

    /**
     * @var \Mockery\Mock
     */
    public $file;

    protected function setUp()
    {
        $this->archive = new \Chumper\Zipper\Zipper(
            $this->file = Mockery::mock(new Filesystem)
        );
        $this->archive->make('foo', new ArrayArchive('foo', true));
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    public function testMake()
    {
        $this->assertEquals('ArrayArchive', $this->archive->getArchiveType());
        $this->assertEquals('foo', $this->archive->getFilePath());
    }


    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Failed to create folder
     */
    public function testMakeThrowsExceptionWhenCouldNotCreateDirectory()
    {
        $path = getcwd() . time();

        $this->file->shouldReceive('makeDirectory')
            ->with($path, 0755, true)
            ->andReturn(false);

        $zip = new Zipper($this->file);

        $zip->make($path . DIRECTORY_SEPARATOR . 'createMe.zip');
    }

    public function testAddAndGet()
    {
        $this->file->shouldReceive('isFile')->with('foo.bar')
            ->times(1)->andReturn(true);
        $this->file->shouldReceive('isFile')->with('foo')
            ->times(1)->andReturn(true);

        $this->archive->add('foo.bar');
        $this->archive->add('foo');

        $this->assertEquals('foo', $this->archive->getFileContent('foo'));
        $this->assertEquals('foo.bar', $this->archive->getFileContent('foo.bar'));
    }

    public function testAddAndGetWithArray()
    {
        $this->file->shouldReceive('isFile')->with('foo.bar')
            ->times(1)->andReturn(true);
        $this->file->shouldReceive('isFile')->with('foo')
            ->times(1)->andReturn(true);

        /**Array**/
        $this->archive->add(array(
            'foo.bar',
            'foo'
        ));

        $this->assertEquals('foo', $this->archive->getFileContent('foo'));
        $this->assertEquals('foo.bar', $this->archive->getFileContent('foo.bar'));
    }

    public function testAddAndGetWithSubFolder()
    {
        /**
         * Add the local folder /path/to/fooDir as folder fooDir to the repository
         * and make sure the folder structure within the repository is there.
         */
        $this->file->shouldReceive('isFile')->with('/path/to/fooDir')
            ->once()->andReturn(false);


        $this->file->shouldReceive('files')->with('/path/to/fooDir')
            ->once()->andReturn(array('fileInFooDir.bar', 'fileInFooDir.foo'));

        $this->file->shouldReceive('directories')->with('/path/to/fooDir')
            ->once()->andReturn(array('fooSubdir'));


        $this->file->shouldReceive('files')->with('/path/to/fooDir/fooSubdir')
            ->once()->andReturn(array('fileInFooDir.bar'));
        $this->file->shouldReceive('directories')->with('/path/to/fooDir/fooSubdir')
            ->once()->andReturn(array());

        $this->archive->folder('fooDir')
            ->add('/path/to/fooDir');

        $this->assertEquals('fooDir/fileInFooDir.bar', $this->archive->getFileContent('fooDir/fileInFooDir.bar'));
        $this->assertEquals('fooDir/fileInFooDir.foo', $this->archive->getFileContent('fooDir/fileInFooDir.foo'));
        $this->assertEquals('fooDir/fooSubdir/fileInFooDir.bar', $this->archive->getFileContent('fooDir/fooSubdir/fileInFooDir.bar'));

    }

    /**
     * @expectedException Exception
     */
    public function testGetFileContent()
    {
        $this->archive->getFileContent('baz');
    }

    public function testRemove()
    {
        $this->file->shouldReceive('isFile')->with('foo')
            ->andReturn(true);

        $this->archive->add('foo');

        $this->assertTrue($this->archive->contains('foo'));

        $this->archive->remove('foo');

        $this->assertFalse($this->archive->contains('foo'));

        //----

        $this->file->shouldReceive('isFile')->with('foo')
            ->andReturn(true);
        $this->file->shouldReceive('isFile')->with('fooBar')
            ->andReturn(true);

        $this->archive->add(array('foo', 'fooBar'));

        $this->assertTrue($this->archive->contains('foo'));
        $this->assertTrue($this->archive->contains('fooBar'));

        $this->archive->remove(array('foo', 'fooBar'));

        $this->assertFalse($this->archive->contains('foo'));
        $this->assertFalse($this->archive->contains('fooBar'));
    }

    public function testExtractWhiteList()
    {
        $this->file
            ->shouldReceive('isFile')
            ->with('foo')
            ->andReturn(true);

        $this->file
            ->shouldReceive('isFile')
            ->with('foo.log')
            ->andReturn(true);

        $this->archive
            ->add('foo')
            ->add('foo.log');

        $this->file
            ->shouldReceive('put')
            ->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'foo', 'foo');

        $this->file
            ->shouldReceive('put')
            ->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'foo.log', 'foo.log');

        $this->archive
            ->extractTo(getcwd(), array('foo'), Zipper::WHITELIST);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Failed to create folder
     */
    public function testExtractToThrowsExceptionWhenCouldNotCreateDirectory()
    {
        $path = getcwd() . time();

        $this->file
            ->shouldReceive('isFile')
            ->with('foo.log')
            ->andReturn(true);

        $this->file->shouldReceive('makeDirectory')
            ->with($path, 0755, true)
            ->andReturn(false);

        $this->archive->add('foo.log');

        $this->file->shouldNotReceive('put')
            ->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'foo.log', 'foo.log');

        $this->archive
            ->extractTo($path, array('foo'), Zipper::WHITELIST);
    }

    public function testExtractWhiteListFromSubDirectory()
    {
        $this->file->shouldReceive('isFile')->andReturn(true);
        $this->file->shouldReceive('makeDirectory')->andReturn(true);

        $this->archive
            ->folder('foo/bar')
            ->add('baz')
            ->add('baz.log');

        $this->file
            ->shouldReceive('put')
            ->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'baz', 'foo/bar/baz');

        $this->file
            ->shouldReceive('put')
            ->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'baz.log', 'foo/bar/baz.log');

        $this->archive
            ->extractTo(getcwd(), array('baz'), Zipper::WHITELIST);
    }

    public function testExtractWhiteListWithExactMatching()
    {
        $this->file->shouldReceive('isFile')->andReturn(true);
        $this->file->shouldReceive('makeDirectory')->andReturn(true);

        $this->archive
            ->folder('foo/bar')
            ->add('baz')
            ->add('baz.log');

        $this->file
            ->shouldReceive('put')
            ->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'baz', 'foo/bar/baz');

        $this->archive
            ->extractTo(getcwd(), array('baz'), Zipper::WHITELIST | Zipper::EXACT_MATCH);
    }

    public function testExtractWhiteListWithExactMatchingFromSubDirectory()
    {
        $this->file->shouldReceive('isFile')->andReturn(true);
        $this->file->shouldReceive('exists')->andReturn(false);
        $this->file->shouldReceive('makeDirectory')->andReturn(true);

        $this->archive->folder('foo/bar/subDirectory')
            ->add('bazInSubDirectory')
            ->add('bazInSubDirectory.log');

        $this->archive->folder('foo/bar')
            ->add('baz')
            ->add('baz.log');

        $subDirectoryPath = realpath(NULL) . DIRECTORY_SEPARATOR . 'subDirectory';
        $subDirectoryFilePath = $subDirectoryPath . '/bazInSubDirectory';
        $this->file->shouldReceive('put')
            ->with($subDirectoryFilePath, 'foo/bar/subDirectory/bazInSubDirectory');

        $this->archive
            ->extractTo(getcwd(), array('subDirectory/bazInSubDirectory'), Zipper::WHITELIST | Zipper::EXACT_MATCH);

        $this->file->shouldHaveReceived('makeDirectory')->with($subDirectoryPath, 0755, true, true);
    }

    public function testExtractToIgnoresBlackListFile()
    {
        $this->file->shouldReceive('isFile')->with('foo')
            ->andReturn(true);
        $this->file->shouldReceive('isFile')->with('bar')
            ->andReturn(true);
        $this->file->shouldReceive('makeDirectory')->andReturn(true);

        $this->archive->add('foo')
            ->add('bar');

        $this->file->shouldReceive('put')->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'foo', 'foo');
        $this->file->shouldNotReceive('put')->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'bar', 'bar');

        $this->archive->extractTo(getcwd(), array('bar'), Zipper::BLACKLIST);
    }

    public function testExtractBlackListFromSubDirectory()
    {
        $currentDir = getcwd();

        $this->file->shouldReceive('isFile')->andReturn(true);
        $this->file->shouldReceive('makeDirectory')->andReturn(true);

        $this->archive->add('rootLevelFile');

        $this->archive->folder('foo/bar/sub')
            ->add('fileInSubSubDir');

        $this->archive->folder('foo/bar')
            ->add('fileInSubDir')
            ->add('fileBlackListedInSubDir');

        $this->file->shouldReceive('put')->with($currentDir . DIRECTORY_SEPARATOR . 'fileInSubDir', 'foo/bar/fileInSubDir');
        $this->file->shouldReceive('put')->with($currentDir . DIRECTORY_SEPARATOR . 'sub/fileInSubSubDir', 'foo/bar/sub/fileInSubSubDir');

        $this->file->shouldNotReceive('put')->with($currentDir . DIRECTORY_SEPARATOR . 'fileBlackListedInSubDir', 'fileBlackListedInSubDir');
        $this->file->shouldNotReceive('put')->with($currentDir . DIRECTORY_SEPARATOR . 'rootLevelFile', 'rootLevelFile');

        $this->archive->extractTo($currentDir, array('fileBlackListedInSubDir'), Zipper::BLACKLIST);
    }

    public function testExtractBlackListFromSubDirectoryWithExactMatching()
    {
        $this->file->shouldReceive('isFile')->with('baz')
            ->andReturn(true);
        $this->file->shouldReceive('makeDirectory')->andReturn(true);

        $this->file->shouldReceive('isFile')->with('baz.log')
            ->andReturn(true);

        $this->archive->folder('foo/bar')
            ->add('baz')
            ->add('baz.log');

        $this->file->shouldReceive('put')->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'baz.log', 'foo/bar/baz.log');

        $this->archive->extractTo(getcwd(), array('baz'), Zipper::BLACKLIST | Zipper::EXACT_MATCH);
    }

    public function testExtractMatchingRegexFromSubFolder()
    {
        $this->file->shouldReceive('isFile')->with('baz')->andReturn(true);
        $this->file->shouldReceive('isFile')->with('baz.log')->andReturn(true);
        $this->file->shouldReceive('isFile')->with('subFolderFileToIgnore')->andReturn(true);
        $this->file->shouldReceive('isFile')->with('subFolderFileToExtract.log')->andReturn(true);
        $this->file->shouldReceive('isFile')->with('rootLevelMustBeIgnored.log')->andReturn(true);

        $this->file->shouldReceive('makeDirectory')->andReturn(true);


        $this->archive->add('rootLevelMustBeIgnored.log');

        $this->archive->folder('foo/bar/subFolder')
            ->add('subFolderFileToIgnore')
            ->add('subFolderFileToExtract.log');

        $this->archive->folder('foo/bar')
            ->add('baz')
            ->add('baz.log');

        $this->file->shouldReceive('put')->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'baz.log', 'foo/bar/baz.log');
        $this->file->shouldReceive('put')->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'subFolder/subFolderFileToExtract.log', 'foo/bar/subFolder/subFolderFileToExtract.log');
        $this->file->shouldNotReceive('put')->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'rootLevelMustBeIgnored.log', 'rootLevelMustBeIgnored.log');
        $this->file->shouldNotReceive('put')->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'baz', 'foo/bar/baz');
        $this->file->shouldNotReceive('put')->with(realpath(NULL) . DIRECTORY_SEPARATOR . 'subFolder/subFolderFileToIgnore', 'foo/bar/subFolder/subFolderFileToIgnore');

        $this->archive->extractMatchingRegex(getcwd(), '/\.log$/i');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Missing pass valid regex parameter
     */
    public function testExtractMatchingRegexThrowsExceptionWhenRegexIsEmpty()
    {
        $this->archive->extractMatchingRegex(getcwd(), '');
    }

    public function testNavigationFolderAndHome()
    {
        $this->archive->folder('foo/bar');
        $this->assertEquals('foo/bar', $this->archive->getCurrentFolderPath());

        //----

        $this->file->shouldReceive('isFile')->with('foo')
            ->andReturn(true);

        $this->archive->add('foo');
        $this->assertEquals('foo/bar/foo', $this->archive->getFileContent('foo/bar/foo'));

        //----

        $this->file->shouldReceive('isFile')->with('bar')
            ->andReturn(true);

        $this->archive->home()->add('bar');
        $this->assertEquals('bar', $this->archive->getFileContent('bar'));

        //----

        $this->file->shouldReceive('isFile')->with('baz/bar/bing')
            ->andReturn(true);

        $this->archive->folder('test')->add('baz/bar/bing');
        $this->assertEquals('test/bing', $this->archive->getFileContent('test/bing'));

    }

    public function testListFiles()
    {
        // testing empty file
        $this->file->shouldReceive('isFile')->with('foo.file')->andReturn(true);
        $this->file->shouldReceive('isFile')->with('bar.file')->andReturn(true);

        $this->assertEquals(array(), $this->archive->listFiles());

        // testing not empty file
        $this->archive->add('foo.file');
        $this->archive->add('bar.file');

        $this->assertEquals(array('foo.file', 'bar.file'), $this->archive->listFiles());

        // testing with a empty sub dir
        $this->file->shouldReceive('isFile')->with('/path/to/subDirEmpty')->andReturn(false);

        $this->file->shouldReceive('files')->with('/path/to/subDirEmpty')->andReturn(array());
        $this->file->shouldReceive('directories')->with('/path/to/subDirEmpty')->andReturn(array());
        $this->archive->folder('subDirEmpty')->add('/path/to/subDirEmpty');

        $this->assertEquals(array('foo.file', 'bar.file'), $this->archive->listFiles());

        // testing with a not empty sub dir
        $this->file->shouldReceive('isFile')->with('/path/to/subDir')->andReturn(false);
        $this->file->shouldReceive('isFile')->with('sub.file')->andReturn(true);

        $this->file->shouldReceive('files')->with('/path/to/subDir')->andReturn(array('sub.file'));
        $this->file->shouldReceive('directories')->with('/path/to/subDir')->andReturn(array());

        $this->archive->folder('subDir')->add('/path/to/subDir');

        $this->assertEquals(array('foo.file', 'bar.file', 'subDir/sub.file'), $this->archive->listFiles());
    }

    public function testListFilesWithRegexFilter()
    {
        // add 2 files to root level in zip
        $this->file->shouldReceive('isFile')->with('foo.file')->andReturn(true);
        $this->file->shouldReceive('isFile')->with('bar.log')->andReturn(true);

        $this->archive
            ->add('foo.file')
            ->add('bar.log');

        // add sub directory with 2 files inside
        $this->file->shouldReceive('isFile')->with('/path/to/subDir')->andReturn(false);
        $this->file->shouldReceive('isFile')->with('sub.file')->andReturn(true);
        $this->file->shouldReceive('isFile')->with('anotherSub.log')->andReturn(true);

        $this->file->shouldReceive('files')->with('/path/to/subDir')->andReturn(array('sub.file', 'anotherSub.log'));
        $this->file->shouldReceive('directories')->with('/path/to/subDir')->andReturn(array());

        $this->archive->folder('subDir')->add('/path/to/subDir');

        $this->assertEquals(
            array('foo.file', 'subDir/sub.file'),
            $this->archive->listFiles('/\.file$/i') // filter out files ending with ".file" pattern
        );
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage regular expression match on 'foo.file' failed with error. Please check if pattern is valid regular expression.
     */
    public function testListFilesThrowsExceptionWithInvalidRegexFilter()
    {
        $this->file->shouldReceive('isFile')->with('foo.file')->andReturn(true);
        $this->archive->add('foo.file');

        $invalidPattern = 'asdasd';
        $this->archive->listFiles($invalidPattern);
    }
}
