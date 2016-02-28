<?php


    /**
     * @group operation
     */
    class WideImage_Operation_ApplyFilter_Test extends WideImage_TestCase
    {
        public function testApplyFilter()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');
            $result = $img->applyFilter(IMG_FILTER_EDGEDETECT);

            $this->assertTrue($result instanceof WideImage_TrueColorImage);
            $this->assertTrue($result->isTransparent());

            $this->assertEquals(100, $result->getWidth());
            $this->assertEquals(100, $result->getHeight());
        }
    }
