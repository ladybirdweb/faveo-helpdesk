<?php
	
	require dirname(__FILE__) . '/../lib/WideImage.php';
	
	define('TEST_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
	define('IMG_PATH', TEST_PATH . 'images' . DIRECTORY_SEPARATOR);
	
	abstract class WideImage_TestCase extends PHPUnit_Framework_TestCase
	{
		function load($file)
		{
			return WideImage::load(IMG_PATH . $file);
		}
		
		function assertValidImage($image)
		{
			$this->assertInstanceOf("WideImage_Image", $image);
			$this->assertTrue($image->isValid());
		}
		
		function assertDimensions($image, $width, $height)
		{
			$this->assertEquals($width, $image->getWidth());
			$this->assertEquals($height, $image->getHeight());
		}
		
		function assertTransparentColorMatch($img1, $img2)
		{
			$tc1 = $img1->getTransparentColorRGB();
			$tc2 = $img2->getTransparentColorRGB();
			$this->assertEquals($tc1, $tc2);
		}
		
		function assertTransparentColorAt($img, $x, $y)
		{
			$this->assertEquals($img->getTransparentColor(), $img->getColorAt($x, $y));
		}
		
		function assertRGBWithinMargin($rec, $r, $g, $b, $a, $margin)
		{
			if (is_array($r))
			{
				$a = $r['alpha'];
				$b = $r['blue'];
				$g = $r['green'];
				$r = $r['red'];
			}
			
			$result = 
				abs($rec['red'] - $r) <= $margin && 
				abs($rec['green'] - $g) <= $margin && 
				abs($rec['blue'] - $b) <= $margin;
			
			$result = $result && ($a === null || abs($rec['alpha'] - $a) <= $margin);
			
			$this->assertTrue($result, 
				"RGBA [{$rec['red']}, {$rec['green']}, {$rec['blue']}, {$rec['alpha']}] " . 
				"doesn't match RGBA [$r, $g, $b, $a] within margin [$margin].");
		}
		
		function assertRGBAt($img, $x, $y, $rgba)
		{
			if (is_array($rgba))
				$cmp = $img->getRGBAt($x, $y);
			else
				$cmp = $img->getColorAt($x, $y);
			$this->assertSame($cmp, $rgba);
		}
		
		function assertRGBNear($rec, $r, $g = null, $b = null, $a = null)
		{
			$this->assertRGBWithinMargin($rec, $r, $g, $b, $a, 2);
		}
		
		function assertRGBEqual($rec, $r, $g = null, $b = null, $a = null)
		{
			$this->assertRGBWithinMargin($rec, $r, $g, $b, $a, 0);
		}
	}
	