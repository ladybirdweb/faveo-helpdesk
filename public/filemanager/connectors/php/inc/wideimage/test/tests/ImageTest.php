<?php
    /**
     
     **/

    /**
     */
    class WideImage_Operation_CustomOp
    {
        public static $args = null;

        public function execute()
        {
            self::$args = func_get_args();

            return self::$args[0]->copy();
        }
    }

    /**
     */
    class ImageForOutput extends WideImage_TrueColorImage
    {
        public $headers = [];

        public function writeHeader($name, $data)
        {
            $this->headers[$name] = $data;
        }
    }

    /**
     */
    class TestableImage extends WideImage_TrueColorImage
    {
        public $headers = [];

        public function __destruct()
        {
        }

        public function writeHeader($name, $data)
        {
            $this->headers[$name] = $data;
        }
    }

    /**
     */
    class WideImage_Image_Test extends WideImage_TestCase
    {
        public function testFactories()
        {
            $this->assertTrue(WideImage::createTrueColorImage(100, 100) instanceof WideImage_TrueColorImage);
            $this->assertTrue(WideImage::createPaletteImage(100, 100) instanceof WideImage_PaletteImage);
        }

        public function testDestructorUponUnset()
        {
            $img = $this->getMock('WideImage_TrueColorImage', [], [imagecreatetruecolor(10, 10)]);
            $img->expectOnce('destroy');
            unset($img);
            $img = null;

            for ($i = 0; $i++; $i < 1000);
        }

        public function testDestructorUponNull()
        {
            $img = $this->getMock('WideImage_TrueColorImage', [], [imagecreatetruecolor(10, 10)]);
            $img->expectOnce('destroy');
            $img = null;

            for ($i = 0; $i++; $i < 1000);
        }

        public function testAutoDestruct()
        {
            $img = WideImage_TrueColorImage::create(10, 10);
            $handle = $img->getHandle();

            unset($img);

            $this->assertFalse(WideImage::isValidImageHandle($handle));
        }

        public function testAutoDestructWithRelease()
        {
            $img = WideImage_TrueColorImage::create(10, 10);
            $handle = $img->getHandle();

            $img->releaseHandle();
            unset($img);

            $this->assertTrue(WideImage::isValidImageHandle($handle));
            imagedestroy($handle);
        }

        public function testCustomOpMagic()
        {
            $img = WideImage_TrueColorImage::create(10, 10);
            $result = $img->customOp(123, 'abc');
            $this->assertTrue($result instanceof WideImage_Image);
            $this->assertSame(WideImage_Operation_CustomOp::$args[0], $img);
            $this->assertSame(WideImage_Operation_CustomOp::$args[1], 123);
            $this->assertSame(WideImage_Operation_CustomOp::$args[2], 'abc');
        }

        public function testCustomOpCaseInsensitive()
        {
            $img = WideImage_TrueColorImage::create(10, 10);
            $result = $img->CUSTomOP(123, 'abc');
            $this->assertTrue($result instanceof WideImage_Image);
            $this->assertSame(WideImage_Operation_CustomOp::$args[0], $img);
            $this->assertSame(WideImage_Operation_CustomOp::$args[1], 123);
            $this->assertSame(WideImage_Operation_CustomOp::$args[2], 'abc');
        }

        public function testInternalOpCaseInsensitive()
        {
            $img = WideImage_TrueColorImage::create(10, 10);
            $result = $img->AUTOcrop();
            $this->assertTrue($result instanceof WideImage_Image);
        }

        public function testOutput()
        {
            $tmp = WideImage::load(IMG_PATH.'fgnl.jpg');
            $img = new ImageForOutput($tmp->getHandle());

            ob_start();
            $img->output('png');
            $data = ob_get_clean();

            $this->assertEquals(['Content-length' => strlen($data), 'Content-type' => 'image/png'], $img->headers);
        }

        public function testCanvasInstance()
        {
            $img = WideImage::load(IMG_PATH.'fgnl.jpg');
            $canvas1 = $img->getCanvas();
            $this->assertTrue($canvas1 instanceof WideImage_Canvas);
            $canvas2 = $img->getCanvas();
            $this->assertTrue($canvas1 === $canvas2);
        }

        public function testSerializeTrueColorImage()
        {
            $img = WideImage::load(IMG_PATH.'fgnl.jpg');
            $img2 = unserialize(serialize($img));
            $this->assertEquals(get_class($img2), get_class($img));
            $this->assertTrue($img2->isTrueColor());
            $this->assertTrue($img2->isValid());
            $this->assertFalse($img2->isTransparent());
            $this->assertEquals($img->getWidth(), $img2->getWidth());
            $this->assertEquals($img->getHeight(), $img2->getHeight());
        }

        public function testSerializePaletteImage()
        {
            $img = WideImage::load(IMG_PATH.'100x100-color-hole.gif');
            $img2 = unserialize(serialize($img));
            $this->assertEquals(get_class($img2), get_class($img));
            $this->assertFalse($img2->isTrueColor());
            $this->assertTrue($img2->isValid());
            $this->assertTrue($img2->isTransparent());
            $this->assertEquals($img->getWidth(), $img2->getWidth());
            $this->assertEquals($img->getHeight(), $img2->getHeight());
        }
    }
