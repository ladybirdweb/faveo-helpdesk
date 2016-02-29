<?php


    /**
     * @group operation
     */
    class WideImage_Operation_RoundCorners_Test extends WideImage_TestCase
    {
        public function testWhiteCorner()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.png');
            $res = $img->roundCorners(30, $img->allocateColor(255, 255, 255), WideImage::SIDE_ALL);

            $this->assertEquals(100, $res->getWidth());
            $this->assertEquals(100, $res->getHeight());

            $this->assertRGBAt($res, 5, 5, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0]);
            $this->assertRGBAt($res, 95, 5, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0]);
            $this->assertRGBAt($res, 95, 95, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0]);
            $this->assertRGBAt($res, 5, 95, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0]);
        }

        public function testTransparentCorner()
        {
            $img = WideImage::load(IMG_PATH.'100x100-blue-alpha.png');
            $res = $img->roundCorners(30, null, WideImage::SIDE_ALL);

            $this->assertEquals(100, $res->getWidth());
            $this->assertEquals(100, $res->getHeight());

            $this->assertRGBAt($res, 5, 5, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 127]);
            $this->assertRGBAt($res, 95, 5, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 127]);
            $this->assertRGBAt($res, 95, 95, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 127]);
            $this->assertRGBAt($res, 5, 95, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 127]);
        }
    }
