<?php
    /**
     
     **/
    include WideImage::path().'Mapper/BMP.php';

    /**
     */
    class WideImage_Mapper_BMP_Test extends WideImage_TestCase
    {
        /**
         * @var WideImage_Mapper_BMP
         */
        protected $mapper;

        public function setup()
        {
            $this->mapper = WideImage_MapperFactory::selectMapper(null, 'bmp');
        }

        public function teardown()
        {
            $this->mapper = null;
        }

        public function testLoad()
        {
            $handle = $this->mapper->load(IMG_PATH.'fgnl.bmp');
            $this->assertTrue(is_resource($handle));
            $this->assertEquals(174, imagesx($handle));
            $this->assertEquals(287, imagesy($handle));
            imagedestroy($handle);
        }

        public function testSaveToString()
        {
            $handle = WideImage_vendor_de77_BMP::imagecreatefrombmp(IMG_PATH.'fgnl.bmp');
            ob_start();
            $this->mapper->save($handle);
            $string = ob_get_clean();
            $this->assertTrue(strlen($string) > 0);
            imagedestroy($handle);

            // string contains valid image data
            $handle = $this->mapper->loadFromString($string);
            $this->assertTrue(WideImage::isValidImageHandle($handle));
            imagedestroy($handle);
        }

        public function testSaveToFile()
        {
            $handle = imagecreatefromgif(IMG_PATH.'100x100-color-hole.gif');
            $this->mapper->save($handle, IMG_PATH.'temp/test.bmp');
            $this->assertTrue(filesize(IMG_PATH.'temp/test.bmp') > 0);
            imagedestroy($handle);

            // file is a valid image
            $handle = $this->mapper->load(IMG_PATH.'temp/test.bmp');
            $this->assertTrue(WideImage::isValidImageHandle($handle));
            imagedestroy($handle);
        }
    }
