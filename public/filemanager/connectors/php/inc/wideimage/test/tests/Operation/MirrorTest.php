<?php


    class WideImage_Operation_Mirror_Test extends WideImage_TestCase
    {
        public function testMirror()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');

            $this->assertRGBEqual($img->getRGBAt(5, 5), 255, 255, 0);
            $this->assertRGBEqual($img->getRGBAt(95, 5), 0, 0, 255);
            $this->assertRGBEqual($img->getRGBAt(95, 95), 0, 255, 0);
            $this->assertRGBEqual($img->getRGBAt(5, 95), 255, 0, 0);

            $new = $img->mirror();

            $this->assertTrue($new instanceof WideImage_PaletteImage);

            $this->assertEquals(100, $new->getWidth());
            $this->assertEquals(100, $new->getHeight());

            $this->assertRGBEqual($new->getRGBAt(95, 5), 255, 255, 0);
            $this->assertRGBEqual($new->getRGBAt(5, 5), 0, 0, 255);
            $this->assertRGBEqual($new->getRGBAt(5, 95), 0, 255, 0);
            $this->assertRGBEqual($new->getRGBAt(95, 95), 255, 0, 0);

            $this->assertTrue($new->isTransparent());
            $this->assertRGBEqual($new->getRGBAt(50, 50), $img->getTransparentColorRGB());
        }
    }
