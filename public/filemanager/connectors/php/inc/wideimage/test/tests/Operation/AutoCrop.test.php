<?php
    /**
     
     **/

    /**
     */
    class WideImage_Operation_Autocrop_Test extends WideImage_TestCase
    {
        public function testAutocrop()
        {
            $img = WideImage::load(IMG_PATH.'100x100-red-spot.png');

            $cropped = $img->autocrop();
            $this->assertTrue($cropped instanceof WideImage_TrueColorImage);
            $this->assertEquals(71, $cropped->getWidth());
            $this->assertEquals(70, $cropped->getHeight());

            $this->assertRGBNear($cropped->getRGBAt(10, 10), 255, 0, 0);
        }

        public function testAutocropHalfImageBug()
        {
            $img = WideImage::load(IMG_PATH.'100x100-red-spot-half-cut.png');

            $cropped = $img->autocrop();
            $this->assertTrue($cropped instanceof WideImage_TrueColorImage);
            $this->assertEquals(22, $cropped->getWidth());
            $this->assertEquals(23, $cropped->getHeight());

            $this->assertRGBNear($cropped->getRGBAt(10, 10), 255, 0, 0);
        }
    }
