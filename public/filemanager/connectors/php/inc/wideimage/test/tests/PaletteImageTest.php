<?php


    class WideImage_PaletteImage_Test extends WideImage_TestCase
    {
        public function testCreate()
        {
            $img = WideImage_PaletteImage::create(10, 10);
            $this->assertTrue($img instanceof WideImage_PaletteImage);
            $this->assertTrue($img->isValid());
            $this->assertFalse($img->isTrueColor());
        }

        public function testCopy()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');
            $this->assertTrue($img instanceof WideImage_PaletteImage);
            $this->assertTrue($img->isValid());
            $this->assertFalse($img->isTrueColor());
            $this->assertTrue($img->isTransparent());
            $this->assertRGBEqual($img->getRGBAt(15, 15), 255, 255, 0);
            $this->assertRGBEqual($img->getRGBAt(85, 15), 0, 0, 255);
            $this->assertRGBEqual($img->getRGBAt(85, 85), 0, 255, 0);
            $this->assertRGBEqual($img->getRGBAt(15, 85), 255, 0, 0);
            $this->assertTrue($img->getTransparentColor() === $img->getColorAt(50, 50));

            $copy = $img->copy();
            $this->assertFalse($img->getHandle() === $copy->getHandle());

            $this->assertTrue($copy instanceof WideImage_PaletteImage);
            $this->assertTrue($copy->isValid());
            $this->assertFalse($copy->isTrueColor());
            $this->assertTrue($copy->isTransparent());
            $this->assertRGBEqual($copy->getRGBAt(15, 15), 255, 255, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 15), 0, 0, 255);
            $this->assertRGBEqual($copy->getRGBAt(85, 85), 0, 255, 0);
            $this->assertRGBEqual($copy->getRGBAt(15, 85), 255, 0, 0);
            $this->assertTrue($copy->getTransparentColor() === $copy->getColorAt(50, 50));

            $this->assertSame($img->getTransparentColorRGB(), $copy->getTransparentColorRGB());
        }

        public function testAsTrueColor()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');
            $this->assertTrue($img instanceof WideImage_PaletteImage);
            $this->assertTrue($img->isValid());

            $copy = $img->asTrueColor();
            $this->assertFalse($img->getHandle() === $copy->getHandle());

            $this->assertTrue($copy instanceof WideImage_TrueColorImage);
            $this->assertTrue($copy->isValid());
            $this->assertTrue($copy->isTrueColor());
            $this->assertTrue($copy->isTransparent());
            $this->assertRGBEqual($copy->getRGBAt(15, 15), 255, 255, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 15), 0, 0, 255);
            $this->assertRGBEqual($copy->getRGBAt(85, 85), 0, 255, 0);
            $this->assertRGBEqual($copy->getRGBAt(15, 85), 255, 0, 0);

            $this->assertEquals($copy->getRGBAt(50, 50), $copy->getTransparentColorRGB());
            $rgb = $copy->getTransparentColorRGB();
            $this->assertRGBEqual($img->getTransparentColorRGB(), $rgb['red'], $rgb['green'], $rgb['blue']);
        }
    }
