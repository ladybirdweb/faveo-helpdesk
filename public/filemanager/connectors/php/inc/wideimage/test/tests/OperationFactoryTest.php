<?php


    class WideImage_Operation_MyOperation
    {
    }

    class WideImage_OperationFactory_Test extends WideImage_TestCase
    {
        public function testFactoryReturnsCached()
        {
            $op1 = WideImage_OperationFactory::get('Mirror');
            $op2 = WideImage_OperationFactory::get('Mirror');
            $this->assertSame($op1, $op2);
        }

        /**
         * @expectedException WideImage_UnknownImageOperationException
         */
        public function testNoOperation()
        {
            $op = WideImage_OperationFactory::get('NoSuchOp');
        }

        public function testUserDefinedOp()
        {
            $op = WideImage_OperationFactory::get('MyOperation');
            $this->assertTrue($op instanceof WideImage_Operation_MyOperation);
        }
    }
