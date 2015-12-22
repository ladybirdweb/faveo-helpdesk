<?php

use Chumper\Datatable\Columns\TextColumn;

class TextColumnTest extends PHPUnit_Framework_TestCase {

    public function testWorking()
    {
        $column = new TextColumn('foo', 'FooBar');
        $this->assertEquals('FooBar', $column->run(array()));
    }

}
