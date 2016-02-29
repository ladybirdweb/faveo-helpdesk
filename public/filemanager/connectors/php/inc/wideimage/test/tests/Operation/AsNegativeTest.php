<?php


    class WideImage_Operation_AsNegativeTest extends WideImage_TestCase
    {
        public function skip()
        {
            $this->skipUnless(function_exists('imagefilter'));
        }

        public function testTransparentGIF()
        {
            $img = $this->load('100x100-color-hole.gif');

            $res = $img->asNegative();

            $this->assertDimensions($res, 100, 100);
            $this->assertInstanceOf('WideImage_PaletteImage', $res);

            $this->assertRGBNear($res->getRGBAt(10, 10), 0, 0, 255);
            $this->assertRGBNear($res->getRGBAt(90, 10), 255, 255, 0);
            $this->assertRGBNear($res->getRGBAt(90, 90), 255, 0, 255);
            $this->assertRGBNear($res->getRGBAt(10, 90), 0, 255, 255);

            // preserves transparency
            $this->assertTrue($res->isTransparent());
            $this->assertTransparentColorAt($res, 50, 50);
        }

        public function testTransparentLogoGIF()
        {
            $img = $this->load('logo.gif');
            $this->assertTransparentColorAt($img, 1, 1);

            $res = $img->asNegative();
            $this->assertDimensions($res, 150, 23);
            $this->assertInstanceOf('WideImage_PaletteImage', $res);

            // preserves transparency
            $this->assertTrue($res->isTransparent());
            $this->assertTransparentColorAt($res, 1, 1);
        }

        public function testPNGAlpha()
        {
            $img = $this->load('100x100-blue-alpha.png');

            $res = $img->asNegative();

            $this->assertDimensions($res, 100, 100);
            $this->assertInstanceOf('WideImage_TrueColorImage', $res);

            $this->assertRGBNear($res->getRGBAt(25, 25), 255, 255, 0, 32);
            $this->assertRGBNear($res->getRGBAt(75, 25), 255, 255, 0, 64);
            $this->assertRGBNear($res->getRGBAt(75, 75), 255, 255, 0, 96);
            $this->assertRGBNear($res->getRGBAt(25, 75), 255, 255, 255, 127);

            $this->assertFalse($res->isTransparent());
        }
    }
