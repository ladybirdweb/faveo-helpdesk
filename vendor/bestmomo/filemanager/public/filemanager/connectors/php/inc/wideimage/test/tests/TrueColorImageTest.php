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
	class WideImage_TrueColorImage_Test extends WideImage_TestCase
	{
		function testCreate()
		{
			$img = WideImage_TrueColorImage::create(10, 10);
			$this->assertTrue($img instanceof WideImage_TrueColorImage);
			$this->assertTrue($img->isValid());
			$this->assertTrue($img->isTrueColor());
		}
		
		function testCopy()
		{
			$img = WideImage::load(IMG_PATH . '100x100-rgbyg.png');
			$this->assertTrue($img instanceof WideImage_TrueColorImage);
			$this->assertTrue($img->isValid());
			$this->assertTrue($img->isTrueColor());
			$this->assertRGBEqual($img->getRGBAt(15, 15), 0, 0, 255);
			$this->assertRGBEqual($img->getRGBAt(85, 15), 255, 0, 0);
			$this->assertRGBEqual($img->getRGBAt(85, 85), 255, 255, 0);
			$this->assertRGBEqual($img->getRGBAt(15, 85), 0, 255, 0);
			$this->assertRGBEqual($img->getRGBAt(50, 50), 127, 127, 127);
			
			$copy = $img->copy();
			$this->assertFalse($img->getHandle() === $copy->getHandle());
			
			$this->assertTrue($copy instanceof WideImage_TrueColorImage);
			$this->assertTrue($copy->isValid());
			$this->assertTrue($copy->isTrueColor());
			$this->assertRGBEqual($copy->getRGBAt(15, 15), 0, 0, 255);
			$this->assertRGBEqual($copy->getRGBAt(85, 15), 255, 0, 0);
			$this->assertRGBEqual($copy->getRGBAt(85, 85), 255, 255, 0);
			$this->assertRGBEqual($copy->getRGBAt(15, 85), 0, 255, 0);
			$this->assertRGBEqual($copy->getRGBAt(50, 50), 127, 127, 127);
		}
		
		function testCopyAlphaGetsCopied()
		{
			$img = WideImage::load(IMG_PATH . '100x100-blue-alpha.png');
			$this->assertTrue($img instanceof WideImage_TrueColorImage);
			$this->assertTrue($img->isValid());
			$this->assertTrue($img->isTrueColor());
			$this->assertRGBNear($img->getRGBAt(25, 25), 0, 0, 255, 0.25 * 127);
			$this->assertRGBNear($img->getRGBAt(75, 25), 0, 0, 255, 0.5 * 127);
			$this->assertRGBNear($img->getRGBAt(75, 75), 0, 0, 255, 0.75 * 127);
			$this->assertRGBNear($img->getRGBAt(25, 75), 0, 0, 0, 127);
			
			$copy = $img->copy();
			$this->assertFalse($img->getHandle() === $copy->getHandle());
			
			$this->assertTrue($copy instanceof WideImage_TrueColorImage);
			$this->assertTrue($copy->isValid());
			$this->assertTrue($copy->isTrueColor());
			$this->assertRGBNear($copy->getRGBAt(25, 25), 0, 0, 255, 0.25 * 127);
			$this->assertRGBNear($copy->getRGBAt(75, 25), 0, 0, 255, 0.5 * 127);
			$this->assertRGBNear($copy->getRGBAt(75, 75), 0, 0, 255, 0.75 * 127);
			$this->assertRGBNear($copy->getRGBAt(25, 75), 0, 0, 0, 127);
		}
		
		function testAsPalette()
		{
			if (function_exists('imagecolormatch'))
			{
				$img = WideImage::load(IMG_PATH . '100x100-rgbyg.png');
				$this->assertTrue($img instanceof WideImage_TrueColorImage);
				$this->assertTrue($img->isValid());
				$this->assertTrue($img->isTrueColor());
				
				$copy = $img->asPalette();
				$this->assertFalse($img->getHandle() === $copy->getHandle());
				
				$this->assertTrue($copy instanceof WideImage_PaletteImage);
				$this->assertTrue($copy->isValid());
				$this->assertFalse($copy->isTrueColor());
				$this->assertRGBEqual($copy->getRGBAt(15, 15), 0, 0, 255);
				$this->assertRGBEqual($copy->getRGBAt(85, 15), 255, 0, 0);
				$this->assertRGBEqual($copy->getRGBAt(85, 85), 255, 255, 0);
				$this->assertRGBEqual($copy->getRGBAt(15, 85), 0, 255, 0);
				$this->assertRGBEqual($copy->getRGBAt(50, 50), 127, 127, 127);
			}
		}
		
		function testPreserveTransparency()
		{
			$img = WideImage::load(IMG_PATH . '100x100-color-hole.gif');
			$this->assertTrue($img->isTransparent());
			$this->assertRGBEqual($img->getTransparentColorRGB(), 255, 255, 255);
			
			$tc = $img->asTrueColor();
			$this->assertTrue($tc->isTransparent());
			$this->assertRGBEqual($tc->getTransparentColorRGB(), 255, 255, 255);
			
			$img = $tc->asPalette();
			$this->assertTrue($img->isTransparent());
			$this->assertRGBEqual($img->getTransparentColorRGB(), 255, 255, 255);
		}
	}
