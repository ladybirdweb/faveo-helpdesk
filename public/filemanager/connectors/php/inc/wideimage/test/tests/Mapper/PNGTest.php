<?php

    include WideImage::path().'Mapper/PNG.php';

    class WideImage_Mapper_PNG_Test extends WideImage_TestCase
    {
        protected $mapper;

        public function setup()
        {
            $this->mapper = WideImage_MapperFactory::selectMapper(null, 'png');
        }

        public function teardown()
        {
            $this->mapper = null;

            if (file_exists(IMG_PATH.'temp/test.png')) {
                unlink(IMG_PATH.'temp/test.png');
            }
        }

        public function testLoad()
        {
            $handle = $this->mapper->load(IMG_PATH.'100x100-color-hole.png');
            $this->assertTrue(is_resource($handle));
            $this->assertEquals(100, imagesx($handle));
            $this->assertEquals(100, imagesy($handle));
            imagedestroy($handle);
        }

        public function testSaveToString()
        {
            $handle = imagecreatefrompng(IMG_PATH.'100x100-color-hole.png');
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
            $handle = imagecreatefrompng(IMG_PATH.'100x100-color-hole.png');
            $this->mapper->save($handle, IMG_PATH.'temp/test.png');
            $this->assertTrue(filesize(IMG_PATH.'temp/test.png') > 0);
            imagedestroy($handle);

            // file is a valid image
            $handle = imagecreatefrompng(IMG_PATH.'temp/test.png');
            $this->assertTrue(is_resource($handle));
            imagedestroy($handle);
        }

        public function testSaveCompression()
        {
            $handle = $this->mapper->load(IMG_PATH.'100x100-rainbow.png');
            $file1 = IMG_PATH.'temp/test-comp-0.png';
            $file2 = IMG_PATH.'temp/test-comp-9.png';
            $this->mapper->save($handle, $file1, 0);
            $this->mapper->save($handle, $file2, 9);
            $this->assertTrue(filesize($file1) > filesize($file2));

            unlink($file1);
            unlink($file2);
        }
    }
