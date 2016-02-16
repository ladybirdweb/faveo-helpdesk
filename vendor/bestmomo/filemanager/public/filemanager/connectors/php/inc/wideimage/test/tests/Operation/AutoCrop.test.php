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
	class WideImage_Operation_Autocrop_Test extends WideImage_TestCase
	{
		function testAutocrop()
		{
			$img = WideImage::load(IMG_PATH . '100x100-red-spot.png');
			
			$cropped = $img->autocrop();
			$this->assertTrue($cropped instanceof WideImage_TrueColorImage);
			$this->assertEquals(71, $cropped->getWidth());
			$this->assertEquals(70, $cropped->getHeight());
			
			$this->assertRGBNear($cropped->getRGBAt(10, 10), 255, 0, 0);
		}
		
		function testAutocropHalfImageBug()
		{
			$img = WideImage::load(IMG_PATH . '100x100-red-spot-half-cut.png');
			
			$cropped = $img->autocrop();
			$this->assertTrue($cropped instanceof WideImage_TrueColorImage);
			$this->assertEquals(22, $cropped->getWidth());
			$this->assertEquals(23, $cropped->getHeight());
			
			$this->assertRGBNear($cropped->getRGBAt(10, 10), 255, 0, 0);
		}
	}
