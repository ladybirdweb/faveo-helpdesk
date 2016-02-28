<?php


    class WideImage_Mapper_FOO
    {
        public static $calls = [];
        public static $handle = null;

        public static function reset()
        {
            self::$calls = [];
            self::$handle = null;
        }

        public function load()
        {
            self::$calls['load'] = func_get_args();

            return self::$handle;
        }

        public function loadFromString($data)
        {
            self::$calls['loadFromString'] = func_get_args();

            return self::$handle;
        }

        public function save($image, $uri = null)
        {
            self::$calls['save'] = func_get_args();
            if ($uri == null) {
                echo 'out';
            }

            return true;
        }
    }

    class WideImage_Mapper_FOO2
    {
        public static $calls = [];

        public static function reset()
        {
            self::$calls = [];
        }

        public function load()
        {
            self::$calls['load'] = func_get_args();

            return false;
        }

        public function loadFromString($data)
        {
            self::$calls['loadFromString'] = func_get_args();
        }

        public function save($image, $uri = null)
        {
            self::$calls['save'] = func_get_args();
            if ($uri == null) {
                echo 'out';
            }
        }
    }

    class WideImage_Test extends WideImage_TestCase
    {
        protected $_FILES;

        public function setup()
        {
            $this->_FILES = $_FILES;
            $_FILES = [];
        }

        public function teardown()
        {
            $_FILES = $this->_FILES;

            if (PHP_OS == 'WINNT') {
                chdir(IMG_PATH.'temp');

                foreach (new DirectoryIterator(IMG_PATH.'temp') as $file) {
                    if (!$file->isDot()) {
                        if ($file->isDir()) {
                            exec("rd /S /Q {$file->getFilename()}\n");
                        } else {
                            unlink($file->getFilename());
                        }
                    }
                }
            } else {
                exec('rm -rf '.IMG_PATH.'temp/*');
            }
        }

        public function testLoadFromFile()
        {
            $img = WideImage::load(IMG_PATH.'100x100-red-transparent.gif');
            $this->assertTrue($img instanceof WideImage_PaletteImage);
            $this->assertValidImage($img);
            $this->assertFalse($img->isTrueColor());
            $this->assertEquals(100, $img->getWidth());
            $this->assertEquals(100, $img->getHeight());

            $img = WideImage::load(IMG_PATH.'100x100-rainbow.png');
            $this->assertTrue($img instanceof WideImage_TrueColorImage);
            $this->assertValidImage($img);
            $this->assertTrue($img->isTrueColor());
            $this->assertEquals(100, $img->getWidth());
            $this->assertEquals(100, $img->getHeight());
        }

        public function testLoadFromString()
        {
            $img = WideImage::load(file_get_contents(IMG_PATH.'100x100-rainbow.png'));
            $this->assertTrue($img instanceof WideImage_TrueColorImage);
            $this->assertValidImage($img);
            $this->assertTrue($img->isTrueColor());
            $this->assertEquals(100, $img->getWidth());
            $this->assertEquals(100, $img->getHeight());
        }

        public function testLoadFromHandle()
        {
            $handle = imagecreatefrompng(IMG_PATH.'100x100-rainbow.png');
            $img = WideImage::loadFromHandle($handle);
            $this->assertValidImage($img);
            $this->assertTrue($img->isTrueColor());
            $this->assertSame($handle, $img->getHandle());
            $this->assertEquals(100, $img->getWidth());
            $this->assertEquals(100, $img->getHeight());
            unset($img);
            $this->assertFalse(WideImage::isValidImageHandle($handle));
        }

        public function testLoadFromUpload()
        {
            copy(IMG_PATH.'100x100-rainbow.png', IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg');
            $_FILES = [
                'testupl' => [
                    'name'     => '100x100-rainbow.png',
                    'type'     => 'image/png',
                    'size'     => strlen(file_get_contents(IMG_PATH.'100x100-rainbow.png')),
                    'tmp_name' => IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg',
                    'error'    => false,
                ],
            ];

            $img = WideImage::loadFromUpload('testupl');
            $this->assertValidImage($img);
        }

        public function testLoadFromMultipleUploads()
        {
            copy(IMG_PATH.'100x100-rainbow.png', IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg1');
            copy(IMG_PATH.'splat.tga', IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg2');
            $_FILES = [
                'testupl' => [
                    'name' => ['100x100-rainbow.png', 'splat.tga'],
                    'type' => ['image/png', 'image/tga'],
                    'size' => [
                            strlen(file_get_contents(IMG_PATH.'100x100-rainbow.png')),
                            strlen(file_get_contents(IMG_PATH.'splat.tga')),
                        ],
                    'tmp_name' => [
                            IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg1',
                            IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg2',
                        ],
                    'error' => [false, false],
                ],
            ];

            $images = WideImage::loadFromUpload('testupl');
            $this->assertInternalType('array', $images);
            $this->assertValidImage($images[0]);
            $this->assertValidImage($images[1]);

            $img = WideImage::loadFromUpload('testupl', 1);
            $this->assertValidImage($img);
        }

        public function testLoadMagicalFromHandle()
        {
            $img = WideImage::load(imagecreatefrompng(IMG_PATH.'100x100-rainbow.png'));
            $this->assertValidImage($img);
        }

        public function testLoadMagicalFromBinaryString()
        {
            $img = WideImage::load(file_get_contents(IMG_PATH.'100x100-rainbow.png'));
            $this->assertValidImage($img);
        }

        public function testLoadMagicalFromFile()
        {
            $img = WideImage::load(IMG_PATH.'100x100-rainbow.png');
            $this->assertValidImage($img);
            copy(IMG_PATH.'100x100-rainbow.png', IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg');
            $_FILES = [
                'testupl' => [
                    'name'     => 'fgnl.bmp',
                    'type'     => 'image/bmp',
                    'size'     => strlen(file_get_contents(IMG_PATH.'fgnl.bmp')),
                    'tmp_name' => IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg',
                    'error'    => false,
                ],
            ];
            $img = WideImage::load('testupl');
            $this->assertValidImage($img);
        }

        public function testLoadFromStringWithCustomMapper()
        {
            $img = WideImage::loadFromString(file_get_contents(IMG_PATH.'splat.tga'));
            $this->assertValidImage($img);
        }

        public function testLoadFromFileWithInvalidExtension()
        {
            $img = WideImage::load(IMG_PATH.'actually-a-png.jpg');
            $this->assertValidImage($img);
        }

        public function testLoadFromFileWithInvalidExtensionWithCustomMapper()
        {
            if (PHP_OS == 'WINNT') {
                $this->markTestSkipped('For some reason, this test kills PHP my 32-bit Vista + PHP 5.3.1.');
            }

            $img = WideImage::loadFromFile(IMG_PATH.'fgnl-bmp.jpg');
            $this->assertValidImage($img);
        }

        /**
         * @expectedException WideImage_InvalidImageSourceException
         */
        public function testLoadFromStringEmpty()
        {
            WideImage::loadFromString('');
        }

        public function testLoadBMPMagicalFromUpload()
        {
            copy(IMG_PATH.'fgnl.bmp', IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg');
            $_FILES = [
                'testupl' => [
                    'name'     => 'fgnl.bmp',
                    'type'     => 'image/bmp',
                    'size'     => strlen(file_get_contents(IMG_PATH.'fgnl.bmp')),
                    'tmp_name' => IMG_PATH.'temp'.DIRECTORY_SEPARATOR.'upltmpimg',
                    'error'    => false,
                ],
            ];
            $img = WideImage::load('testupl');
            $this->assertValidImage($img);
        }

        public function testMapperLoad()
        {
            WideImage_Mapper_FOO::$handle = imagecreate(10, 10);
            $filename = IMG_PATH.'/image.foo';
            WideImage::registerCustomMapper('WideImage_Mapper_FOO', 'image/foo', 'foo');
            $img = WideImage::load($filename);
            $this->assertEquals(WideImage_Mapper_FOO::$calls['load'], [$filename]);
            imagedestroy(WideImage_Mapper_FOO::$handle);
        }

        public function testLoadFromFileFallbackToLoadFromString()
        {
            WideImage_Mapper_FOO::$handle = imagecreate(10, 10);
            $filename = IMG_PATH.'/image-actually-foo.foo2';
            WideImage::registerCustomMapper('WideImage_Mapper_FOO', 'image/foo', 'foo');
            WideImage::registerCustomMapper('WideImage_Mapper_FOO2', 'image/foo2', 'foo2');
            $img = WideImage::load($filename);
            $this->assertEquals(WideImage_Mapper_FOO2::$calls['load'], [$filename]);
            $this->assertEquals(WideImage_Mapper_FOO::$calls['loadFromString'], [file_get_contents($filename)]);
            imagedestroy(WideImage_Mapper_FOO::$handle);
        }

        public function testMapperSaveToFile()
        {
            $img = WideImage::load(IMG_PATH.'fgnl.jpg');
            $img->saveToFile('test.foo', '123', 789);
            $this->assertEquals(WideImage_Mapper_FOO::$calls['save'], [$img->getHandle(), 'test.foo', '123', 789]);
        }

        public function testMapperAsString()
        {
            $img = WideImage::load(IMG_PATH.'fgnl.jpg');
            $str = $img->asString('foo', '123', 789);
            $this->assertEquals(WideImage_Mapper_FOO::$calls['save'], [$img->getHandle(), null, '123', 789]);
            $this->assertEquals('out', $str);
        }

        /**
         * @expectedException WideImage_InvalidImageSourceException
         */
        public function testInvalidImageFile()
        {
            WideImage::loadFromFile(IMG_PATH.'fakeimage.png');
        }

        /**
         * @expectedException WideImage_InvalidImageSourceException
         */
        public function testEmptyString()
        {
            WideImage::load('');
        }

        /**
         * @expectedException WideImage_InvalidImageSourceException
         */
        public function testInvalidImageStringData()
        {
            WideImage::loadFromString('asdf');
        }

        /**
         * @expectedException WideImage_InvalidImageSourceException
         */
        public function testInvalidImageHandle()
        {
            WideImage::loadFromHandle(0);
        }

        /**
         * @expectedException WideImage_InvalidImageSourceException
         */
        public function testInvalidImageUploadField()
        {
            WideImage::loadFromUpload('xyz');
        }
    }
