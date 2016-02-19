<?php
    /**
     
     **/

    /**
     */
    class WideImage_Operation_GetMask_Test extends WideImage_TestCase
    {
        public function testGetMaskTransparentGif()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');

            $mask = $img->getMask();
            $this->assertTrue($mask instanceof WideImage_TrueColorImage);

            $this->assertFalse($mask->isTransparent());
            $this->assertEquals(100, $mask->getWidth());
            $this->assertEquals(100, $mask->getHeight());

            $this->assertRGBNear($mask->getRGBAt(10, 10), 255, 255, 255);
            $this->assertRGBNear($mask->getRGBAt(90, 90), 255, 255, 255);
            $this->assertRGBNear($mask->getRGBAt(50, 50), 0, 0, 0);
        }

        public function testGetMaskPNGAlpha()
        {
            $img = WideImage::load(IMG_PATH.'100x100-blue-alpha.png');

            $mask = $img->getMask();
            $this->assertTrue($mask instanceof WideImage_TrueColorImage);

            $this->assertFalse($mask->isTransparent());
            $this->assertEquals(100, $mask->getWidth());
            $this->assertEquals(100, $mask->getHeight());

            $this->assertRGBNear($mask->getRGBAt(25, 25), 192, 192, 192);
            $this->assertRGBNear($mask->getRGBAt(75, 25), 128, 128, 128);
            $this->assertRGBNear($mask->getRGBAt(75, 75), 64, 64, 64);
            $this->assertRGBNear($mask->getRGBAt(25, 75), 0, 0, 0);
        }
    }
