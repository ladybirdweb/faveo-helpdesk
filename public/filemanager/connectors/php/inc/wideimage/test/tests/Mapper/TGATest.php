<?php
    /**
     
     **/
    include WideImage::path().'Mapper/TGA.php';

    /**
     * @group mapper
     */
    class WideImage_Mapper_TGA_Test extends WideImage_TestCase
    {
        /**
         * @var WideImage_Mapper_TGA
         */
        protected $mapper;

        public function setup()
        {
            $this->mapper = WideImage_MapperFactory::selectMapper(null, 'tga');
        }

        public function teardown()
        {
            $this->mapper = null;
        }

        public function testLoad()
        {
            $handle = $this->mapper->load(IMG_PATH.'splat.tga');
            $this->assertTrue(is_resource($handle));
            $this->assertEquals(100, imagesx($handle));
            $this->assertEquals(100, imagesy($handle));
            imagedestroy($handle);
        }

        /**
         * @expectedException WideImage_Exception
         */
        public function testSaveToStringNotSupported()
        {
            $handle = WideImage_vendor_de77_BMP::imagecreatefrombmp(IMG_PATH.'splat.tga');
            $this->mapper->save($handle);
        }

        /**
         * @expectedException WideImage_Exception
         */
        public function testSaveToFileNotSupported()
        {
            $handle = imagecreatefromgif(IMG_PATH.'100x100-color-hole.gif');
            $this->mapper->save($handle, IMG_PATH.'temp/test.bmp');
        }
    }
