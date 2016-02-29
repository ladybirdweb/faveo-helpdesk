<?php


    class WideImage_Operation_ApplyMask_Test extends WideImage_TestCase
    {
        public function testApplyMask()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');
            $mask = WideImage::load(IMG_PATH.'75x25-gray.png');

            $result = $img->applyMask($mask);
            $this->assertTrue($result instanceof WideImage_TrueColorImage);
            $this->assertTrue($result->isTransparent());

            $this->assertEquals(100, $result->getWidth());
            $this->assertEquals(100, $result->getHeight());

            $this->assertRGBNear($result->getRGBAt(10, 10), 255, 255, 255);
            $this->assertRGBNear($result->getRGBAt(30, 10), 255, 255, 0, 64);
            $this->assertRGBNear($result->getRGBAt(60, 10), 0, 0, 255, 0);
        }
    }
