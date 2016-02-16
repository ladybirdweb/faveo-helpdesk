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
	
	include WideImage::path() . 'Mapper/BMP.php';
	
	/**
	 * @package Tests
	 */
	class WideImage_Mapper_BMP_Test extends WideImage_TestCase
	{
		/**
		 * @var WideImage_Mapper_BMP
		 */
		protected $mapper;
		
		function setup()
		{
			$this->mapper = WideImage_MapperFactory::selectMapper(null, 'bmp');
		}
		
		function teardown()
		{
			$this->mapper = null;
		}
		
		function testLoad()
		{
			$handle = $this->mapper->load(IMG_PATH . 'fgnl.bmp');
			$this->assertTrue(is_resource($handle));
			$this->assertEquals(174, imagesx($handle));
			$this->assertEquals(287, imagesy($handle));
			imagedestroy($handle);
		}
		
		function testSaveToString()
		{
			$handle = WideImage_vendor_de77_BMP::imagecreatefrombmp(IMG_PATH . 'fgnl.bmp');
			ob_start();
			$this->mapper->save($handle);
			$string = ob_get_clean();
			$this->assertTrue(strlen($string) > 0);
			imagedestroy($handle);
			
			// string contains valid image data
			$handle = $this->mapper->loadFromString($string);
			$this->assertTrue(WideImage::isValidImageHandle($handle));
			imagedestroy($handle);
		}
		
		function testSaveToFile()
		{
			$handle = imagecreatefromgif(IMG_PATH . '100x100-color-hole.gif');
			$this->mapper->save($handle, IMG_PATH . 'temp/test.bmp');
			$this->assertTrue(filesize(IMG_PATH . 'temp/test.bmp') > 0);
			imagedestroy($handle);
			
			// file is a valid image
			$handle = $this->mapper->load(IMG_PATH . 'temp/test.bmp');
			$this->assertTrue(WideImage::isValidImageHandle($handle));
			imagedestroy($handle);
		}
	}
