<?php

namespace Unit;


use Flow\File;
use Flow\FustyRequest;
use Flow\Config;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;

/**
 * FustyRequest unit tests
 *
 * @coversDefaultClass \Flow\FustyRequest
 *
 * @package Unit
 */
class FustyRequestTest extends FlowUnitCase
{
	/**
	 * Virtual file system
	 *
	 * @var vfsStreamDirectory
	 */
	protected $vfs;

    protected function setUp()
    {
	    parent::setUp();

        vfsStreamWrapper::register();
        $this->vfs = new vfsStreamDirectory('chunks');
        vfsStreamWrapper::setRoot($this->vfs);
    }

	/**
	 * @covers ::__construct
	 * @covers ::isFustyFlowRequest
	 */
    public function testFustyRequest_construct()
    {
	    $firstChunk = vfsStream::newFile('temp_file');
	    $firstChunk->setContent('1234567890');
	    $this->vfs->addChild($firstChunk);

	    $fileInfo = new \ArrayObject(array(
		    'size' => 10,
		    'error' => UPLOAD_ERR_OK,
		    'tmp_name' => $firstChunk->url()
	    ));

	    $request =  new \ArrayObject(array(
		    'flowIdentifier' => '13632-prettifyjs',
		    'flowFilename' => 'prettify.js',
		    'flowRelativePath' => 'home/prettify.js'
	    ));

	    $fustyRequest = new FustyRequest($request, $fileInfo);

	    $this->assertSame('prettify.js', $fustyRequest->getFileName());
	    $this->assertSame('13632-prettifyjs', $fustyRequest->getIdentifier());
	    $this->assertSame('home/prettify.js', $fustyRequest->getRelativePath());
	    $this->assertSame(1, $fustyRequest->getCurrentChunkNumber());
	    $this->assertTrue($fustyRequest->isFustyFlowRequest());
	    $this->assertSame(10, $fustyRequest->getTotalSize());
	    $this->assertSame(10, $fustyRequest->getDefaultChunkSize());
	    $this->assertSame(10, $fustyRequest->getCurrentChunkSize());
	    $this->assertSame(1, $fustyRequest->getTotalChunks());
    }

	/**
	 */
	public function testFustyRequest_ValidateUpload()
	{
		//// Setup test

		$firstChunk = vfsStream::newFile('temp_file');
		$firstChunk->setContent('1234567890');
		$this->vfs->addChild($firstChunk);

		$fileInfo = new \ArrayObject(array(
			'size' => 10,
			'error' => UPLOAD_ERR_OK,
			'tmp_name' => $firstChunk->url()
		));

		$request =  new \ArrayObject(array(
			'flowIdentifier' => '13632-prettifyjs',
			'flowFilename' => 'prettify.js',
			'flowRelativePath' => 'home/prettify.js'
		));

		$fustyRequest = new FustyRequest($request, $fileInfo);

		$config = new Config();
		$config->setTempDir($this->vfs->url());

		/** @var File $file */
		$file = $this->getMock('Flow\File', array('_move_uploaded_file'), array($config, $fustyRequest));

		/** @noinspection PhpUndefinedMethodInspection */
		$file->expects($this->once())
		     ->method('_move_uploaded_file')
		     ->will($this->returnCallback(function ($filename, $destination) {
			     return rename($filename, $destination);
		     }));

		//// Actual test

		$this->assertTrue($file->validateChunk());
		$this->assertFalse($file->validateFile());

		$this->assertTrue($file->saveChunk());
		$this->assertTrue($file->validateFile());
		$path = $this->vfs->url() . DIRECTORY_SEPARATOR . 'new';
		$this->assertTrue($file->save($path));
		$this->assertEquals(10, filesize($path));
	}
}
