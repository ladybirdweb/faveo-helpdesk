<?php
    /**
     
     **/

    /**
     * @group operation
     */
    class WideImage_Operation_CorrectGamma_Test extends WideImage_TestCase
    {
        public function test()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');
            $result = $img->correctGamma(1, 2);

            $this->assertTrue($result instanceof WideImage_PaletteImage);
            $this->assertTrue($result->isTransparent());

            $this->assertEquals(100, $result->getWidth());
            $this->assertEquals(100, $result->getHeight());
        }
    }
