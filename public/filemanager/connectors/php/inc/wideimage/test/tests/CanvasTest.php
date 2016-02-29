<?php


    class WideImage_Canvas_Test extends WideImage_TestCase
    {
        public function testCreate()
        {
            $img = WideImage::createTrueColorImage(10, 10);

            $canvas1 = $img->getCanvas();
            $this->assertInstanceOf('WideImage_Canvas', $canvas1);

            $canvas2 = $img->getCanvas();
            $this->assertSame($canvas1, $canvas2);
        }

        public function testMagicCallDrawRectangle()
        {
            $img = WideImage::createTrueColorImage(10, 10);
            $canvas = $img->getCanvas();
            $canvas->filledRectangle(1, 1, 5, 5, $img->allocateColorAlpha(255, 0, 0, 64));
            $this->assertRGBAt($img, 3, 3, ['red' => 255, 'green' => 0, 'blue' => 0, 'alpha' => 64]);
        }
    }
