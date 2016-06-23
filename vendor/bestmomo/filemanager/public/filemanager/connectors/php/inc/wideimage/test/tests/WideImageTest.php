<?php
	/**
    This file is part of WideImage.
		
    WideImage is free software; you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation; either version 2.1 of the License, or
    (at your option) any later version.
		
    WideImage is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.
		
    You should have received a copy of the GNU Lesser General Public License
    along with WideImage; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
    * @package Tests
  **/
	
	/**
	 * @package Tests
	 */
	class WideImage_Mapper_FOO
	{
		public static $calls = array();
		public static $handle = null;
		
		static function reset()
		{
			self::$calls = array();
			self::$handle = null;
		}
		
		function load()
		{
			self::$calls['load'] = func_get_args();
			return self::$handle;
		}
		
		function loadFromString($data)
		{
			self::$calls['loadFromString'] = func_get_args();
			return self::$handle;
		}
		
		function save($image, $uri = null)
		{
			self::$calls['save'] = func_get_args();
			if ($uri == null)
				echo 'out';
			return true;
		}
	}
	
	class WideImage_Mapper_FOO2
	{
		public static $calls = array();
		
		static function reset()
		{
			self::$calls = array();
		}
		
		function load()
		{
			self::$calls['load'] = func_get_args();
			return false;
		}
		
		function loadFromString($data)
		{
			self::$calls['loadFromString'] = func_get_args();
		}
		
		function save($image, $uri = null)
		{
			self::$calls['save'] = func_get_args();
			if ($uri == null)
				echo 'out';
		}
	}
	
	/**
	 * @package Tests
	 */
	class WideImage_Test extends WideImage_TestCase
	{
		protected $_FILES;
		function setup()
		{
			$this->_FILES = $_FILES;
			$_FILES = array();
		}
		
		function teardown()
		{
			$_FILES = $this->_FILES;
			
			if (PHP_OS == 'WINNT')
			{
				chdir(IMG_PATH . "temp");
				
				foreach (new DirectoryIterator(IMG_PATH . "temp") as $file)
					if (!$file->isDot())
						if ($file->isDir())
							exec("rd /S /Q {$file->getFilename()}\n");
						else
							unlink($file->getFilename());
			}
			else
				exec("rm -rf " . IMG_PATH . 'temp/*');
		}
		
		function testLoadFromFile()
		{
			$img = WideImage::load(IMG_PATH . '100x100-red-transparent.gif');
			$this->assertTrue($img instanceof WideImage_PaletteImage);
			$this->assertValidImage($img);
			$this->assertFalse($img->isTrueColor());
			$this->assertEquals(100, $img->getWidth());
			$this->assertEquals(100, $img->getHeight());
			
			$img = WideImage::load(IMG_PATH . '100x100-rainbow.png');
			$this->assertTrue($img instanceof WideImage_TrueColorImage);
			$this->assertValidImage($img);
			$this->assertTrue($img->isTrueColor());
			$this->assertEquals(100, $img->getWidth());
			$this->assertEquals(100, $img->getHeight());
		}
		
		function testLoadFromString()
		{
			$img = WideImage::load(file_get_contents(IMG_PATH . '100x100-rainbow.png'));
			$this->assertTrue($img instanceof WideImage_TrueColorImage);
			$this->assertValidImage($img);
			$this->assertTrue($img->isTrueColor());
			$this->assertEquals(100, $img->getWidth());
			$this->assertEquals(100, $img->getHeight());
		}
		
		function testLoadFromHandle()
		{
			$handle = imagecreatefrompng(IMG_PATH . '100x100-rainbow.png');
			$img = WideImage::loadFromHandle($handle);
			$this->assertValidImage($img);
			$this->assertTrue($img->isTrueColor());
			$this->assertSame($handle, $img->getHandle());
			$this->assertEquals(100, $img->getWidth());
			$this->assertEquals(100, $img->getHeight());
			unset($img);
			$this->assertFalse(WideImage::isValidImageHandle($handle));
		}
		
		function testLoadFromUpload()
		{
			copy(IMG_PATH . '100x100-rainbow.png', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg');
			$_FILES = array(
				'testupl' => array(
					'name' => '100x100-rainbow.png',
					'type' => 'image/png',
					'size' => strlen(file_get_contents(IMG_PATH . '100x100-rainbow.png')),
					'tmp_name' => IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg',
					'error' => false,
				)
			);
			
			$img = WideImage::loadFromUpload('testupl');
			$this->assertValidImage($img);
		}
		
		function testLoadFromMultipleUploads()
		{
			copy(IMG_PATH . '100x100-rainbow.png', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg1');
			copy(IMG_PATH . 'splat.tga', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg2');
			$_FILES = array(
				'testupl' => array(
					'name' => array('100x100-rainbow.png', 'splat.tga'),
					'type' => array('image/png', 'image/tga'),
					'size' => array(
							strlen(file_get_contents(IMG_PATH . '100x100-rainbow.png')), 
							strlen(file_get_contents(IMG_PATH . 'splat.tga'))
						),
					'tmp_name' => array(
							IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg1',
							IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg2'
						),
					'error' => array(false, false),
				)
			);
			
			$images = WideImage::loadFromUpload('testupl');
			$this->assertInternalType("array", $images);
			$this->assertValidImage($images[0]);
			$this->assertValidImage($images[1]);
			
			$img = WideImage::loadFromUpload('testupl', 1);
			$this->assertValidImage($img);
		}
		
		function testLoadMagicalFromHandle()
		{
			$img = WideImage::load(imagecreatefrompng(IMG_PATH . '100x100-rainbow.png'));
			$this->assertValidImage($img);
		}
		
		
		function testLoadMagicalFromBinaryString()
		{
			$img = WideImage::load(file_get_contents(IMG_PATH . '100x100-rainbow.png'));
			$this->assertValidImage($img);
		}
		
		function testLoadMagicalFromFile()
		{
			$img = WideImage::load(IMG_PATH . '100x100-rainbow.png');
			$this->assertValidImage($img);
			copy(IMG_PATH . '100x100-rainbow.png', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg');
			$_FILES = array(
				'testupl' => array(
					'name' => 'fgnl.bmp',
					'type' => 'image/bmp',
					'size' => strlen(file_get_contents(IMG_PATH . 'fgnl.bmp')),
					'tmp_name' => IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg',
					'error' => false,
				)
			);
			$img = WideImage::load('testupl');
			$this->assertValidImage($img);
		}
		
		function testLoadFromStringWithCustomMapper()
		{
			$img = WideImage::loadFromString(file_get_contents(IMG_PATH . 'splat.tga'));
			$this->assertValidImage($img);
		}
		
		function testLoadFromFileWithInvalidExtension()
		{
			$img = WideImage::load(IMG_PATH . 'actually-a-png.jpg');
			$this->assertValidImage($img);
		}
		
		function testLoadFromFileWithInvalidExtensionWithCustomMapper()
		{
			if (PHP_OS == 'WINNT')
				$this->markTestSkipped("For some reason, this test kills PHP my 32-bit Vista + PHP 5.3.1.");
			
			$img = WideImage::loadFromFile(IMG_PATH . 'fgnl-bmp.jpg');
			$this->assertValidImage($img);
		}
		
		/**
		 * @expectedException WideImage_InvalidImageSourceException
		 */
		function testLoadFromStringEmpty()
		{
			WideImage::loadFromString('');
		}
		
		function testLoadBMPMagicalFromUpload()
		{
			copy(IMG_PATH . 'fgnl.bmp', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg');
			$_FILES = array(
				'testupl' => array(
					'name' => 'fgnl.bmp',
					'type' => 'image/bmp',
					'size' => strlen(file_get_contents(IMG_PATH . 'fgnl.bmp')),
					'tmp_name' => IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg',
					'error' => false,
				)
			);
			$img = WideImage::load('testupl');
			$this->assertValidImage($img);
		}
		
		function testMapperLoad()
		{
			WideImage_Mapper_FOO::$handle = imagecreate(10, 10);
			$filename = IMG_PATH . '/image.foo';
			WideImage::registerCustomMapper('WideImage_Mapper_FOO', 'image/foo', 'foo');
			$img = WideImage::load($filename);
			$this->assertEquals(WideImage_Mapper_FOO::$calls['load'], array($filename));
			imagedestroy(WideImage_Mapper_FOO::$handle);
		}
		
		function testLoadFromFileFallbackToLoadFromString()
		{
			WideImage_Mapper_FOO::$handle = imagecreate(10, 10);
			$filename = IMG_PATH . '/image-actually-foo.foo2';
			WideImage::registerCustomMapper('WideImage_Mapper_FOO', 'image/foo', 'foo');
			WideImage::registerCustomMapper('WideImage_Mapper_FOO2', 'image/foo2', 'foo2');
			$img = WideImage::load($filename);
			$this->assertEquals(WideImage_Mapper_FOO2::$calls['load'], array($filename));
			$this->assertEquals(WideImage_Mapper_FOO::$calls['loadFromString'], array(file_get_contents($filename)));
			imagedestroy(WideImage_Mapper_FOO::$handle);
		}
		
		function testMapperSaveToFile()
		{
			$img = WideImage::load(IMG_PATH . 'fgnl.jpg');
			$img->saveToFile('test.foo', '123', 789);
			$this->assertEquals(WideImage_Mapper_FOO::$calls['save'], array($img->getHandle(), 'test.foo', '123', 789));
		}
		
		function testMapperAsString()
		{
			$img = WideImage::load(IMG_PATH . 'fgnl.jpg');
			$str = $img->asString('foo', '123', 789);
			$this->assertEquals(WideImage_Mapper_FOO::$calls['save'], array($img->getHandle(), null, '123', 789));
			$this->assertEquals('out', $str);
		}
		
		/**
		 * @expectedException WideImage_InvalidImageSourceException
		 */
		function testInvalidImageFile()
		{
			WideImage::loadFromFile(IMG_PATH . 'fakeimage.png');
		}
		
		/**
		 * @expectedException WideImage_InvalidImageSourceException
		 */
		function testEmptyString()
		{
			WideImage::load('');
		}
		
		/**
		 * @expectedException WideImage_InvalidImageSourceException
		 */
		function testInvalidImageStringData()
		{
			WideImage::loadFromString('asdf');
		}
		
		/**
		 * @expectedException WideImage_InvalidImageSourceException
		 */
		function testInvalidImageHandle()
		{
			WideImage::loadFromHandle(0);
		}
		
		/**
		 * @expectedException WideImage_InvalidImageSourceException
		 */
		function testInvalidImageUploadField()
		{
			WideImage::loadFromUpload('xyz');
		}
	}
