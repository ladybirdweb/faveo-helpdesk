<?php


    /**
     * @group operation
     */
    class WideImage_Operation_Merge_Test extends WideImage_TestCase
    {
        public function testMergeOpacityZero()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.png');
            $overlay = WideImage::load(IMG_PATH.'100x100-square-overlay.png');

            $res = $img->merge($overlay, 0, 0, 0);

            $this->assertEquals(100, $res->getWidth());
            $this->assertEquals(100, $res->getHeight());

            $rgb = $res->getRGBAt(5, 5);
            $this->assertRGBAt($res, 5, 5, ['red' => 255, 'green' => 255, 'blue' => 0, 'alpha' => 0]);
            $this->assertRGBAt($res, 40, 40, ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 127]);
            $this->assertRGBAt($res, 95, 5, ['red' => 0, 'green' => 0, 'blue' => 255, 'alpha' => 0]);
            $this->assertRGBAt($res, 60, 40, ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 127]);
            $this->assertRGBAt($res, 95, 95, ['red' => 0, 'green' => 255, 'blue' => 0, 'alpha' => 0]);
            $this->assertRGBAt($res, 60, 60, ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 127]);
            $this->assertRGBAt($res, 5, 95, ['red' => 255, 'green' => 0, 'blue' => 0, 'alpha' => 0]);
            $this->assertRGBAt($res, 40, 60, ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 127]);
        }

        public function testMergeOpacityHalf()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.png');
            $overlay = WideImage::load(IMG_PATH.'100x100-square-overlay.png');

            $res = $img->merge($overlay, 0, 0, 50);

            $this->assertEquals(100, $res->getWidth());
            $this->assertEquals(100, $res->getHeight());

            $rgb = $res->getRGBAt(5, 5);
            $this->assertRGBAt($res, 5, 5, ['red' => 255, 'green' => 255, 'blue' => 127, 'alpha' => 0]);
            $this->assertRGBAt($res, 40, 40, ['red' => 127, 'green' => 127, 'blue' => 127, 'alpha' => 0]);
            $this->assertRGBAt($res, 95, 5, ['red' => 0, 'green' => 0, 'blue' => 255, 'alpha' => 0]);
            $this->assertRGBAt($res, 60, 40, ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 127]);
            $this->assertRGBAt($res, 95, 95, ['red' => 0, 'green' => 127, 'blue' => 0, 'alpha' => 0]);

            // these two should definitely pass ...

            //$this->assertRGBAt($res, 60, 60, array('red' => 127, 'green' => 127, 'blue' => 127, 'alpha' => 0));
            $this->assertRGBAt($res, 5, 95, ['red' => 255, 'green' => 0, 'blue' => 0, 'alpha' => 0]);
            //$this->assertRGBAt($res, 40, 60, array('red' => 255, 'green' => 127, 'blue' => 127, 'alpha' => 0));
        }

        public function testMergeOpacityFull()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.png');
            $overlay = WideImage::load(IMG_PATH.'100x100-square-overlay.png');

            $res = $img->merge($overlay, 0, 0, 100);

            $this->assertEquals(100, $res->getWidth());
            $this->assertEquals(100, $res->getHeight());

            $rgb = $res->getRGBAt(5, 5);
            $this->assertRGBAt($res, 5, 5, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0]);
            $this->assertRGBAt($res, 40, 40, ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0]);
            $this->assertRGBAt($res, 95, 5, ['red' => 0, 'green' => 0, 'blue' => 255, 'alpha' => 0]);
            $this->assertRGBAt($res, 60, 40, ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 127]);
            $this->assertRGBAt($res, 95, 95, ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 0]);
            $this->assertRGBAt($res, 60, 60, ['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 0]);
            $this->assertRGBAt($res, 5, 95, ['red' => 255, 'green' => 0, 'blue' => 0, 'alpha' => 0]);
            $this->assertRGBAt($res, 40, 60, ['red' => 255, 'green' => 0, 'blue' => 0, 'alpha' => 0]);
        }
    }
