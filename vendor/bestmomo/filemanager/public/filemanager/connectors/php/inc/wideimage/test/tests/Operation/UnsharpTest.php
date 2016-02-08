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
	 * @group operation
	 */
	class WideImage_Operation_Unsharp_Test extends WideImage_TestCase
	{
		function test()
		{
			$img = WideImage::load(IMG_PATH . '100x100-color-hole.gif');
			$result = $img->unsharp(10, 5, 1);
			
			$this->assertTrue($result instanceof WideImage_PaletteImage);
			$this->assertTrue($result->isTransparent());
			
			$this->assertEquals(100, $result->getWidth());
			$this->assertEquals(100, $result->getHeight());
		}
	}
