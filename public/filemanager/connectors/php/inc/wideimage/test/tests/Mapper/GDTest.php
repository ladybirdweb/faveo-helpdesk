<?php
    /**
     
     **/
    include WideImage::path().'Mapper/GD.php';

    /**
     */
    class WideImage_Mapper_GD_Test extends WideImage_TestCase
    {
        /**
         * @var WideImage_Mapper_GD
         */
        protected $mapper;

        public function setup()
        {
            $this->mapper = WideImage_MapperFactory::selectMapper(null, 'gd');
        }

        public function teardown()
        {
            $this->mapper = null;

            if (file_exists(IMG_PATH.'temp/test.gd')) {
                unlink(IMG_PATH.'temp/test.gd');
            }
        }

        public function testSaveAndLoad()
        {
            $handle = imagecreatefromgif(IMG_PATH.'100x100-color-hole.gif');
            $this->mapper->save($handle, IMG_PATH.'temp/test.gd');
            $this->assertTrue(filesize(IMG_PATH.'temp/test.gd') > 0);
            imagedestroy($handle);

            // file is a valid image
            $handle = $this->mapper->load(IMG_PATH.'temp/test.gd');
            $this->assertTrue(WideImage::isValidImageHandle($handle));
            imagedestroy($handle);
        }
    }
