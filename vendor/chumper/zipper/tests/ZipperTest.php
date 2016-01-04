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

    public function __construct()
    {
        $this->archive = new \Chumper\Zipper\Zipper(
            $this->file = Mockery::mock(new Filesystem)
        );
        $this->archive->make('foo', new ArrayArchive('foo', true));
    }

    public function testMake()
    {
        $this->assertEquals('ArrayArchive', $this->archive->getArchiveType());
        $this->assertEquals('foo', $this->archive->getFilePath());
    }

    public function testExtractTo()
    {

    }

    public function testAddAndGet()
    {
        $this->file->shouldReceive('isFile')->with('foo.bar')
            ->times(3)->andReturn(true);
        $this->file->shouldReceive('isFile')->with('foo')
            ->times(3)->andReturn(true);

        /**Array**/
        $this->file->shouldReceive('isFile')->with('/path/to/fooDir')
            ->once()->andReturn(false);

        $this->file->shouldReceive('files')->with('/path/to/fooDir')
            ->once()->andReturn(array('foo.bar', 'bar.foo'));
        $this->file->shouldReceive('directories')->with('/path/to/fooDir')
            ->once()->andReturn(array('fooSubdir'));

        $this->file->shouldReceive('files')->with('/path/to/fooDir/fooSubdir')
            ->once()->andReturn(array('foo.bar'));
        $this->file->shouldReceive('directories')->with('/path/to/fooDir/fooSubdir')
            ->once()->andReturn(array());

        //test1
        $this->archive->add('foo.bar');
        $this->archive->add('foo');

        $this->assertEquals('foo', $this->archive->getFileContent('foo'));
        $this->assertEquals('foo.bar', $this->archive->getFileContent('foo.bar'));

        //test2
        $this->archive->add(array(
            'foo.bar',
            'foo'
        ));
        $this->assertEquals('foo', $this->archive->getFileContent('foo'));
        $this->assertEquals('foo.bar', $this->archive->getFileContent('foo.bar'));

        /**
         * test3:
         * Add the local folder /path/to/fooDir as folder fooDir to the repository
         * and make sure the folder structure within the repository is there.
         */
        $this->archive->folder('fooDir')->add('/path/to/fooDir');
        $this->assertEquals('fooDir/foo.bar', $this->archive->getFileContent('fooDir/foo.bar'));
        $this->assertEquals('fooDir/bar.foo', $this->archive->getFileContent('fooDir/bar.foo'));
        $this->assertEquals('fooDir/fooSubdir/foo.bar', $this->archive->getFileContent('fooDir/fooSubdir/foo.bar'));

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
        $this->file->shouldReceive('isFile')->with('foo')
            ->andReturn(true);

        $this->archive->add('foo');

        $this->file->shouldReceive('put')->with(realpath(NULL) . '/foo', 'foo');

        $this->archive->extractTo('', array('foo'), Zipper::WHITELIST);

        //----
        $this->file->shouldReceive('isFile')->with('foo')
            ->andReturn(true);

        $this->archive->folder('foo/bar')->add('foo');

        $this->file->shouldReceive('put')->with(realpath(NULL) . '/foo', 'foo/bar/foo');

        $this->archive->extractTo('', array('foo'), Zipper::WHITELIST);

    }

    public function testExtractBlackList()
    {
        $this->file->shouldReceive('isFile')->with('foo')
            ->andReturn(true);

        $this->archive->add('foo');

        $this->file->shouldReceive('put')->with(realpath(NULL) . '/foo', 'foo');

        $this->archive->extractTo('', array(), Zipper::BLACKLIST);

        //----
        $this->file->shouldReceive('isFile')->with('foo')
            ->andReturn(true);

        $this->archive->folder('foo/bar')->add('foo');

        $this->file->shouldReceive('put')->with(realpath(NULL) . '/foo', 'foo/bar/foo');

        $this->archive->extractTo('', array('foo'), Zipper::BLACKLIST);
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
}
