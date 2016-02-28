<?php


    class WideImage_Operation_GetChannels_Test extends WideImage_TestCase
    {
        public function testCopyChannel8bit()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');

            $copy = $img->getChannels('red', 'alpha');
            $this->assertTrue($copy instanceof WideImage_PaletteImage);
            $this->assertTrue($copy->isValid());
            $this->assertFalse($copy->isTrueColor());
            $this->assertTrue($copy->isTransparent());

            $this->assertRGBEqual($copy->getRGBAt(15, 15), 255, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 15), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 85), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(15, 85), 255, 0, 0);
            $this->assertEquals($copy->getTransparentColor(), $copy->getColorAt(50, 50));

            $copy = $img->getChannels('red');
            $this->assertTrue($copy instanceof WideImage_PaletteImage);
            $this->assertTrue($copy->isValid());
            $this->assertFalse($copy->isTrueColor());
            $this->assertTrue($copy->isTransparent());

            $this->assertRGBEqual($copy->getRGBAt(15, 15), 255, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 15), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 85), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(15, 85), 255, 0, 0);
            $this->assertEquals($copy->getTransparentColor(), $copy->getColorAt(50, 50));

            $copy = $img->getChannels('green');
            $this->assertTrue($copy instanceof WideImage_PaletteImage);
            $this->assertTrue($copy->isValid());
            $this->assertFalse($copy->isTrueColor());
            $this->assertTrue($copy->isTransparent());

            $this->assertRGBEqual($copy->getRGBAt(15, 15), 0, 255, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 15), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 85), 0, 255, 0);
            $this->assertRGBEqual($copy->getRGBAt(15, 85), 0, 0, 0);
            $this->assertEquals($copy->getTransparentColor(), $copy->getColorAt(50, 50));
        }

        public function testCopySingleChannel()
        {
            $img = WideImage::load(IMG_PATH.'100x100-rgbyg.png');

            $copy = $img->getChannels('red');
            $this->assertFalse($img->getHandle() === $copy->getHandle());
            $this->assertTrue($copy instanceof WideImage_TrueColorImage);
            $this->assertTrue($copy->isValid());
            $this->assertTrue($copy->isTrueColor());
            $this->assertRGBEqual($copy->getRGBAt(15, 15), 0, 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 15), 255, 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 85), 255, 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(15, 85), 0, 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(50, 50), 127, 0, 0, 0);
            /*
            $copy = $img->copyChannels('green');
            $this->assertFalse($img->getHandle() === $copy->getHandle());
            $this->assertTrue($copy instanceof WideImage_TrueColorImage);
            $this->assertTrue($copy->isValid());
            $this->assertTrue($copy->isTrueColor());
            $this->assertRGBEqual($copy->getRGBAt(15, 15), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 15), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 85), 0, 255, 0);
            $this->assertRGBEqual($copy->getRGBAt(15, 85), 0, 255, 0);
            $this->assertRGBEqual($copy->getRGBAt(50, 50), 0, 127, 0);

            $copy = $img->copyChannels('blue');
            $this->assertFalse($img->getHandle() === $copy->getHandle());
            $this->assertTrue($copy instanceof WideImage_TrueColorImage);
            $this->assertTrue($copy->isValid());
            $this->assertTrue($copy->isTrueColor());
            $this->assertRGBEqual($copy->getRGBAt(15, 15), 0, 0, 255);
            $this->assertRGBEqual($copy->getRGBAt(85, 15), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(85, 85), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(15, 85), 0, 0, 0);
            $this->assertRGBEqual($copy->getRGBAt(50, 50), 0, 0, 127);

            $img = WideImage::load(IMG_PATH . '100x100-blue-alpha.png');
            $copy = $img->copyChannels('alpha');
            $this->assertRGBNear($copy->getRGBAt(25, 25), 0, 0, 0, 0.25 * 127);
            $this->assertRGBNear($copy->getRGBAt(75, 25), 0, 0, 0, 0.5 * 127);
            $this->assertRGBNear($copy->getRGBAt(75, 75), 0, 0, 0, 0.75 * 127);
            $this->assertRGBNear($copy->getRGBAt(25, 75), 0, 0, 0, 127);
            */
        }

        public function testCopyCombinedChannels()
        {
            $img = WideImage::load(IMG_PATH.'100x100-blue-alpha.png');
            $copy = $img->getChannels('blue', 'alpha');
            $this->assertRGBNear($copy->getRGBAt(25, 25), 0, 0, 255, 0.25 * 127);
            $this->assertRGBNear($copy->getRGBAt(75, 25), 0, 0, 255, 0.5 * 127);
            $this->assertRGBNear($copy->getRGBAt(75, 75), 0, 0, 255, 0.75 * 127);
            $this->assertRGBNear($copy->getRGBAt(25, 75), 0, 0, 0, 127);
        }
    }
