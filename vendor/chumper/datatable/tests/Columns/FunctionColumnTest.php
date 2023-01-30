<?php

use Chumper\Datatable\Columns\FunctionColumn;

class FunctionColumnTest extends PHPUnit_Framework_TestCase {

    public function testSimple()
    {
        $column = new FunctionColumn('foo',function($model){
            return "FooBar";
        });
        $this->assertEquals('FooBar', $column->run(array()));
    }

    public function testAdvanced()
    {
        $column = new FunctionColumn('foo',function($model){
            return $model['text'];
        });
        $this->assertEquals('FooBar', $column->run(array('text' => 'FooBar')));
    }

    public function testAdvanced2()
    {
        $column = new FunctionColumn('foo',function($model){
            return $model['text'].'Bar';
        });
        $this->assertEquals('FooBar', $column->run(array('text' => 'Foo')));
    }

}
