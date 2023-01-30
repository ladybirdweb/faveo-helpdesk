<?php

use Chumper\Datatable\Columns\FunctionColumn;
use Chumper\Datatable\Engines\BaseEngine;
use Chumper\Datatable\Engines\EngineInterface;
use Chumper\Datatable\Engines\QueryEngine;
use Illuminate\Support\Collection;

class QueryEngineTest extends PHPUnit_Framework_TestCase {

    /**
     * @var QueryEngine
     */
    public $c;

    /**
     * @var \Mockery\Mock
     */
    public $builder;

    public function setUp()
    {

        Config::shouldReceive('get')->zeroOrMoreTimes()->with("datatable::engine")->andReturn(
            array(
                'exactWordSearch' => false,
            )
        );

        $this->builder = Mockery::mock('Illuminate\Database\Query\Builder');

        $this->c = new QueryEngine($this->builder);
    }

    public function testOrder()
    {
        $this->builder->shouldReceive('orderBy')->with('id', BaseEngine::ORDER_ASC);

        Input::merge(
            array(
                'iSortCol_0' => 0,
                'sSortDir_0' => 'asc'
            )
        );

        //--

        $this->builder->shouldReceive('orderBy')->with('id', BaseEngine::ORDER_DESC);

        Input::merge(
            array(
                'iSortCol_0' => 0,
                'sSortDir_0' => 'desc'
            )
        );

    }

    public function testSearch()
    {
        $this->builder->shouldReceive('where')->withAnyArgs()->andReturn($this->builder);
        $this->builder->shouldReceive('get')->once()->andReturn(new Collection($this->getRealArray()));
        $this->builder->shouldReceive('count')->twice()->andReturn(10);
        $this->builder->shouldReceive('orderBy')->withAnyArgs()->andReturn($this->builder);

        $this->c = new QueryEngine($this->builder);

        $this->addRealColumns($this->c);
        $this->c->searchColumns('foo');

        Input::merge(
            array(
                'sSearch' => 'test'
            )
        );

        $test = json_decode($this->c->make()->getContent());
        $test = $test->aaData;
    }

    public function testSkip()
    {
        $this->builder->shouldReceive('skip')->once()->with(1)->andReturn($this->builder);
        $this->builder->shouldReceive('get')->once()->andReturn(new Collection($this->getRealArray()));
        $this->builder->shouldReceive('count')->twice()->andReturn(10);
        $this->builder->shouldReceive('orderBy')->withAnyArgs()->andReturn($this->builder);

        $this->c = new QueryEngine($this->builder);

        $this->addRealColumns($this->c);

        Input::merge(
            array(
                'iDisplayStart' => 1,
                'sSearch' => null
            )
        );

        $this->c->searchColumns('foo');

        $test = json_decode($this->c->make()->getContent());
        $test = $test->aaData;
    }

    public function testTake()
    {
        $this->builder->shouldReceive('take')->once()->with(1)->andReturn($this->builder);
        $this->builder->shouldReceive('get')->once()->andReturn(new Collection($this->getRealArray()));
        $this->builder->shouldReceive('count')->twice()->andReturn(10);
        $this->builder->shouldReceive('orderBy')->withAnyArgs()->andReturn($this->builder);

        $this->c = new QueryEngine($this->builder);

        $this->addRealColumns($this->c);

        Input::merge(
            array(
                'iDisplayLength' => 1,
                'sSearch' => null,
                'iDisplayStart' => null
            )
        );

        $this->c->searchColumns('foo');

        $test = json_decode($this->c->make()->getContent());
        $test = $test->aaData;
    }

    public function testComplex()
    {


        $this->builder->shouldReceive('get')->andReturn(new Collection($this->getRealArray()));
        $this->builder->shouldReceive('where')->withAnyArgs()->andReturn($this->builder);
        $this->builder->shouldReceive('count')->times(8)->andReturn(10);

        $engine = new QueryEngine($this->builder);

        $this->addRealColumns($engine);
        $engine->searchColumns('foo','bar');
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 't',
            )
        );

        $test = json_decode($engine->make()->getContent());
        $test = $test->aaData;

        $this->assertTrue($this->arrayHasKeyValue('foo','Nils',$test));
        $this->assertTrue($this->arrayHasKeyValue('foo','Taylor',$test));

        //Test2
        $engine = new QueryEngine($this->builder);

        $this->addRealColumns($engine);
        $engine->searchColumns('foo','bar');
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 'plasch',
            )
        );

        $test = json_decode($engine->make()->getContent());
        $test = $test->aaData;

        $this->assertTrue($this->arrayHasKeyValue('foo','Nils',$test));
        $this->assertTrue($this->arrayHasKeyValue('foo','Taylor',$test));

        //test3
        $engine = new QueryEngine($this->builder);

        $this->addRealColumns($engine);
        $engine->searchColumns('foo','bar');
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 'tay',
            )
        );

        $test = json_decode($engine->make()->getContent());
        $test = $test->aaData;

        $this->assertTrue($this->arrayHasKeyValue('foo','Nils',$test));
        $this->assertTrue($this->arrayHasKeyValue('foo','Taylor',$test));

        //test4
        $engine = new QueryEngine($this->builder);

        $this->addRealColumns($engine);
        $engine->searchColumns('foo','bar');
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => '0',
            )
        );

        $test = json_decode($engine->make()->getContent());
        $test = $test->aaData;

        $this->assertTrue($this->arrayHasKeyValue('foo','Nils',$test));
        $this->assertTrue($this->arrayHasKeyValue('foo','Taylor',$test));
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    private function getRealArray()
    {
        return array(
            array(
                'name' => 'Nils Plaschke',
                'email'=> 'github@nilsplaschke.de'
            ),
            array(
                'name' => 'Taylor Otwell',
                'email'=> 'taylorotwell@gmail.com'
            )
        );
    }

    private function addRealColumns($engine)
    {
        $engine->addColumn(new FunctionColumn('foo', function($m){return $m['name'];}));
        $engine->addColumn(new FunctionColumn('bar', function($m){return $m['email'];}));
    }

    private function arrayHasKeyValue($key,$value,$array)
    {
        $array = array_pluck($array,$key);
        foreach ($array as $val)
        {
            if(str_contains($val, $value))
                return true;
        }
        return false;

    }

}
