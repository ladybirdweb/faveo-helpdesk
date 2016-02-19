<?php
    /**
     
     **/
    include WideImage::path().'Mapper/GD2.php';

    /**
     */
    class WideImage_Mapper_GD2_Test extends WideImage_TestCase
    {
        protected $mapper;

        public function setup()
        {
            $this->mapper = WideImage_MapperFactory::selectMapper(null, 'gd2');
        }

        public function teardown()
        {
            $this->mapper = null;

            if (file_exists(IMG_PATH.'temp/test.gd2')) {
                unlink(IMG_PATH.'temp/test.gd2');
            }
        }

        public function testSaveToString()
        {
            $handle = imagecreatefromgif(IMG_PATH.'100x100-color-hole.gif');
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
            $handle = imagecreatefromgif(IMG_PATH.'100x100-color-hole.gif');
            $this->mapper->save($handle, IMG_PATH.'temp/test.gd2');
            $this->assertTrue(filesize(IMG_PATH.'temp/test.gd2') > 0);
            imagedestroy($handle);

            // file is a valid image
            $handle = imagecreatefromgd2(IMG_PATH.'temp/test.gd2');
            $this->assertTrue(WideImage::isValidImageHandle($handle));
            imagedestroy($handle);
        }
    }
