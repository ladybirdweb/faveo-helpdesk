<?php

use Chumper\Datatable\Engines\CollectionEngine;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;

class BaseEngineTest extends TestCase {

    private $collection;

    /**
     * @var CollectionEngine
     */
    private $engine;

    public function setUp()
    {
        // set up config
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("datatable::engine")->andReturn(
            array(
                'exactWordSearch' => false,
                )
        );

        $this->collection = new Collection();
        $this->engine = new CollectionEngine($this->collection);
    }


    /**
     * @expectedException Exception
     */
    public function testAddColumn()
    {
        $this->engine->addColumn('foo', 'bar');

        $this->assertInstanceOf(
            'Chumper\Datatable\Columns\TextColumn',
            $this->engine->getColumn('foo')
        );

        $this->engine->addColumn('foo2', function($model){return $model->fooBar;});

        $this->assertInstanceOf(
            'Chumper\Datatable\Columns\FunctionColumn',
            $this->engine->getColumn('foo2')
        );

        $this->assertEquals(array(1 => 'foo2', 0 => 'foo'), $this->engine->getOrder());

        $this->engine->addColumn();
    }

    public function testClearColumns()
    {
        $this->engine->addColumn('foo','Bar');
        $this->assertInstanceOf(
            'Chumper\Datatable\Columns\TextColumn',
            $this->engine->getColumn('foo')
        );

        $this->engine->clearColumns();
        $this->assertEquals(array(), $this->engine->getOrder());
    }

    public function testSearchColumns()
    {
        $this->engine->searchColumns('id');

        $this->assertEquals(array('id'), $this->engine->getSearchingColumns());

        $this->engine->searchColumns('name', 'email');

        $this->assertEquals(array('name','email'), $this->engine->getSearchingColumns());

        $this->engine->searchColumns(array('foo', 'bar'));

        $this->assertEquals(array('foo', 'bar'), $this->engine->getSearchingColumns());
    }

    public function testOrderColumns()
    {
        $this->engine->orderColumns('id');

        $this->assertEquals(array('id'), $this->engine->getOrderingColumns());

        $this->engine->orderColumns('name', 'email');

        $this->assertEquals(array('name','email'), $this->engine->getOrderingColumns());

        $this->engine->orderColumns(array('foo', 'bar'));

        $this->assertEquals(array('foo', 'bar'), $this->engine->getOrderingColumns());
    }

    public function testShowColumns()
    {
        $this->engine->showColumns('id');

        $this->assertEquals(array('id'), $this->engine->getOrder());

        $this->engine->showColumns('name', 'email');

        $this->assertEquals(array('id','name','email'), $this->engine->getOrder());

        $this->engine->showColumns(array('foo', 'bar'));

        $this->assertEquals(array('id','name','email', 'foo', 'bar'), $this->engine->getOrder());
    }
}
 