<?php
    /**
     
     **/
    WideImage_OperationFactory::get('ResizeCanvas');

    /**
     */
    class WideImage_Operation_ResizeCanvas_Test extends WideImage_TestCase
    {
        public function testResizeCanvasUp()
        {
            $img = WideImage::createTrueColorImage(160, 120);
            $resized = $img->resizeCanvas(180, 180, 0, 0);
            $this->assertDimensions($resized, 180, 180);
        }

        public function testResizeCanvasDown()
        {
            $img = WideImage::createTrueColorImage(160, 120);
            $resized = $img->resizeCanvas(30, 100, 0, 0);
            $this->assertDimensions($resized, 30, 100);
        }

        public function testResizeCanvasPositionsCenter()
        {
            $img = WideImage::createTrueColorImage(20, 20);
            $black = $img->allocateColor(0, 0, 0);
            $white = $img->allocateColor(255, 255, 255);
            $img->fill(0, 0, $black);

            $res = $img->resizeCanvas(40, 40, 'center', 'center', $white);
            $this->assertRGBAt($res, 5, 5, $white);
            $this->assertRGBAt($res, 35, 35, $white);
            $this->assertRGBAt($res, 5, 35, $white);
            $this->assertRGBAt($res, 35, 5, $white);
            $this->assertRGBAt($res, 20, 20, $black);
        }

        public function testResizeCanvasPositionsCorner()
        {
            $img = WideImage::createTrueColorImage(20, 20);
            $black = $img->allocateColor(0, 0, 0);
            $white = $img->allocateColor(255, 255, 255);
            $img->fill(0, 0, $black);

            $res = $img->resizeCanvas(40, 40, 'bottom', 'right', $white);
            $this->assertRGBAt($res, 5, 5, $white);
            $this->assertRGBAt($res, 35, 35, $black);
            $this->assertRGBAt($res, 5, 35, $white);
            $this->assertRGBAt($res, 35, 5, $white);
        }
    }
