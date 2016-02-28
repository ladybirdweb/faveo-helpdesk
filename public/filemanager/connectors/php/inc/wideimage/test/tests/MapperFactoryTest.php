<?php


    class WideImage_MapperFactory_Test extends WideImage_TestCase
    {
        public function testMapperPNGByURI()
        {
            $mapper = WideImage_MapperFactory::selectMapper('uri.png');
            $this->assertInstanceOf('WideImage_Mapper_PNG', $mapper);
        }

        public function testMapperGIFByURI()
        {
            $mapper = WideImage_MapperFactory::selectMapper('uri.gif');
            $this->assertInstanceOf('WideImage_Mapper_GIF', $mapper);
        }

        public function testMapperJPGByURI()
        {
            $mapper = WideImage_MapperFactory::selectMapper('uri.jpg');
            $this->assertInstanceOf('WideImage_Mapper_JPEG', $mapper);
        }

        public function testMapperBMPByURI()
        {
            $mapper = WideImage_MapperFactory::selectMapper('uri.bmp');
            $this->assertInstanceOf('WideImage_Mapper_BMP', $mapper);
        }
    }
