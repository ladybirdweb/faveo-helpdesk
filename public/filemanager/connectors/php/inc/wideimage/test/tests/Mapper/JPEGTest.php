<?php
    /**
     
     **/
    include WideImage::path().'Mapper/JPEG.php';

    /**
     */
    class WideImage_Mapper_JPEG_Test extends WideImage_TestCase
    {
        protected $mapper;

        public function setup()
        {
            $this->mapper = WideImage_MapperFactory::selectMapper(null, 'jpg');
        }

        public function teardown()
        {
            $this->mapper = null;

            if (file_exists(IMG_PATH.'temp/test.jpg')) {
                unlink(IMG_PATH.'temp/test.jpg');
            }
        }

        public function testLoad()
        {
            $handle = $this->mapper->load(IMG_PATH.'fgnl.jpg');
            $this->assertTrue(is_resource($handle));
            $this->assertEquals(174, imagesx($handle));
            $this->assertEquals(287, imagesy($handle));
            imagedestroy($handle);
        }

        public function testSaveToString()
        {
            $handle = imagecreatefromjpeg(IMG_PATH.'fgnl.jpg');
            ob_start();
            $this->mapper->save($handle);
            $string = ob_get_clean();
            $this->assertTrue(strlen($string) > 0);
            imagedestroy($handle);

            // string contains valid image data
            $handle = imagecreatefromstring($string);
            $this->assertTrue(is_resource($handle));
            imagedestroy($handle);
        }

        public function testSaveToFile()
        {
            $handle = imagecreatefromjpeg(IMG_PATH.'fgnl.jpg');
            $this->mapper->save($handle, IMG_PATH.'temp/test.jpg');
            $this->assertTrue(filesize(IMG_PATH.'temp/test.jpg') > 0);
            imagedestroy($handle);

            // file is a valid image
            $handle = imagecreatefromjpeg(IMG_PATH.'temp/test.jpg');
            $this->assertTrue(is_resource($handle));
            imagedestroy($handle);
        }

        public function testQuality()
        {
            $handle = imagecreatefromjpeg(IMG_PATH.'fgnl.jpg');

            ob_start();
            $this->mapper->save($handle, null, 100);
            $hq = ob_get_clean();

            ob_start();
            $this->mapper->save($handle, null, 10);
            $lq = ob_get_clean();

            $this->assertTrue(strlen($hq) > 0);
            $this->assertTrue(strlen($lq) > 0);
            $this->assertTrue(strlen($hq) > strlen($lq));
            imagedestroy($handle);
        }
    }
