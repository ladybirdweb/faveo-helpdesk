<?php
    /**
     
     **/

    /**
     */
    class WideImage_Operation_Rotate_Test extends WideImage_TestCase
    {
        public function skip()
        {
            $this->skipUnless(function_exists('imagerotate'));
        }

        public function testRotateAlphaSafe()
        {
            $img = WideImage::load(IMG_PATH.'100x100-blue-alpha.png');
            $this->assertRGBEqual($img->getRGBAt(25, 25), 0, 0, 255, round(128 / 4));
            $this->assertRGBEqual($img->getRGBAt(75, 25), 0, 0, 255, round(2 * 128 / 4));
            $this->assertRGBEqual($img->getRGBAt(75, 75), 0, 0, 255, round(3 * 128 / 4));
            $this->assertRGBEqual($img->getRGBAt(25, 75), 0, 0, 0, 127);
            $new = $img->rotate(90, null);
            $this->assertEquals(100, $new->getWidth());
            $this->assertEquals(100, $new->getHeight());
        }

        public function testRotateCounterClockwise90()
        {
            $img = WideImage::load(IMG_PATH.'fgnl.jpg');
            $new = $img->rotate(-90);
            $this->assertEquals(287, $new->getWidth());
            $this->assertEquals(174, $new->getHeight());
        }

        public function testRotate45()
        {
            $img = WideImage::load(IMG_PATH.'100x100-rainbow.png');
            $new = $img->rotate(45);
            $this->assertEquals(142, $new->getWidth());
            $this->assertEquals(142, $new->getHeight());
        }
    }
