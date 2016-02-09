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
	
	include WideImage::path() . 'Mapper/TGA.php';
	
	/**
	 * @package Tests
	 * @group mapper
	 */
	class WideImage_Mapper_TGA_Test extends WideImage_TestCase
	{
		/**
		 * @var WideImage_Mapper_TGA
		 */
		protected $mapper;
		
		function setup()
		{
			$this->mapper = WideImage_MapperFactory::selectMapper(null, 'tga');
		}
		
		function teardown()
		{
			$this->mapper = null;
		}
		
		function testLoad()
		{
			$handle = $this->mapper->load(IMG_PATH . 'splat.tga');
			$this->assertTrue(is_resource($handle));
			$this->assertEquals(100, imagesx($handle));
			$this->assertEquals(100, imagesy($handle));
			imagedestroy($handle);
		}
		
		/**
		 * @expectedException WideImage_Exception
		 */
		function testSaveToStringNotSupported()
		{
			$handle = WideImage_vendor_de77_BMP::imagecreatefrombmp(IMG_PATH . 'splat.tga');
			$this->mapper->save($handle);
		}
		
		/**
		 * @expectedException WideImage_Exception
		 */
		function testSaveToFileNotSupported()
		{
			$handle = imagecreatefromgif(IMG_PATH . '100x100-color-hole.gif');
			$this->mapper->save($handle, IMG_PATH . 'temp/test.bmp');
		}
	}
