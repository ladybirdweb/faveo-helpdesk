<?php


    /**
     * @group operation
     */
    class WideImage_Operation_ApplyConvolution_Test extends WideImage_TestCase
    {
        public function testApplyConvolution()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');
            $result = $img->applyConvolution([[2, 0, 0], [0, -1, 0], [0, 0, -1]], 1, 220);

            $this->assertTrue($result instanceof WideImage_TrueColorImage);
            $this->assertTrue($result->isTransparent());

            $this->assertEquals(100, $result->getWidth());
            $this->assertEquals(100, $result->getHeight());
        }
    }
