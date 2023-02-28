<?php

use Chumper\Datatable\Columns\FunctionColumn;
use Chumper\Datatable\Engines\CollectionEngine;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;

class CollectionEngineTest extends TestCase {

    /**
     * @var CollectionEngine
     */
    public $c;

    /**
     * @var \Mockery\Mock
     */
    public $collection;

    /**
     * @var
     */
    private $input;

    public function setUp()
    {
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("datatable::engine")->andReturn(
            array(
                'exactWordSearch' => false,
            )
        );

        parent::setUp();

        Config::shouldReceive('get')->zeroOrMoreTimes()->with("datatable::engine")->andReturn(
            array(
                'exactWordSearch' => false,
            )
        );

        $this->collection = Mockery::mock('Illuminate\Support\Collection');
        $this->c = new CollectionEngine($this->collection);
    }

    public function testOrder()
    {
        $should = array(
            array(
                'id' => 'eoo'
            ),
            array(
                'id' => 'foo'
            )
        );

        Input::replace(
            array(
                'iSortCol_0' => 0,
                'sSortDir_0' => 'asc',
            )
        );

        $engine = new CollectionEngine(new Collection($this->getTestArray()));
        $engine->addColumn(new FunctionColumn('id', function($model){return $model['id'];}));
        $engine->setAliasMapping();
        $this->assertEquals($should, $engine->getArray());

        Input::merge(
            array(
                'iSortCol_0' => 0,
                'sSortDir_0' => 'desc'
            )
        );

        $should2 = array(
            array(
                'id' => 'foo'
            ),
            array(
                'id' => 'eoo'
            )
        );

        $this->assertEquals($should2, $engine->getArray());

    }

    public function testSearch()
    {
        // Facade expection
        Input::replace(
            array(
                'sSearch' => 'eoo'
            )
        );

        $engine = new CollectionEngine(new Collection($this->getTestArray()));
        $engine->addColumn($this->getTestColumns());
        $engine->searchColumns('id');
        $engine->setAliasMapping();

        $should = '{"aaData":[{"id":"eoo"}],"sEcho":0,"iTotalRecords":2,"iTotalDisplayRecords":1}';
        $actual = $engine->make()->getContent();

        $this->assertEquals($should,$actual);
        //------------------TEST 2-----------------
        // search in outputed data
        $engine = new CollectionEngine(new Collection(array(array('foo', 'foo2', 'foo3'),array('bar', 'bar2', 'bar3'))));
        $engine->addColumn(new FunctionColumn('bla', function($row){return $row[0]." - ".$row[1];}));
        $engine->addColumn(new FunctionColumn('1', function($row){return $row[2];}));
        $engine->addColumn(new FunctionColumn('bla3', function($row){return $row[0]." - ".$row[2];}));
        $engine->searchColumns("bla",1);
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 'foo2'
            )
        );

        $should = array(
            array(
                'bla' => 'foo - foo2',
                '1' => 'foo3',
                'bla3' => 'foo - foo3'
            )
        );

        $response = json_decode($engine->make()->getContent());
        $this->assertEquals(json_encode($should), json_encode((array)($response->aaData)));

        //------------------TEST 3-----------------
        // search in initial data
        // TODO: Search in initial data columns?

        $engine = new CollectionEngine(new Collection(array(array('foo', 'foo2', 'foo3'),array('bar', 'bar2', 'bar3'))));
        $engine->addColumn(new FunctionColumn('bla3', function($row){return $row[0]." - ".$row[2];}));
        $engine->addColumn(new FunctionColumn('1', function($row){return $row[1];}));
        $engine->searchColumns("bla3",1);
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 'foo2'
            )
        );

        $should = array(
            array(
                'bla3' => 'foo - foo3',
                '1' => 'foo2'
            )
        );

        $response = json_decode($engine->make()->getContent());
        $this->assertEquals(json_encode($should), json_encode($response->aaData));
    }

    public function testSkip()
    {
        $engine = new CollectionEngine(new Collection($this->getTestArray()));

        $engine->addColumn($this->getTestColumns());
        $engine->setAliasMapping();

        Input::replace(
            array(
                'iDisplayStart' => 1
            )
        );

        $should = array(
            array(
                'id' => 'eoo',
            )
        );
        $this->assertEquals($should, $engine->getArray());
    }

    public function testTake()
    {
        Input::replace(
            array(
                'iDisplayLength' => 1
            )
        );

        $engine = new CollectionEngine(new Collection($this->getTestArray()));
        $engine->addColumn($this->getTestColumns());
        $engine->setAliasMapping();
        $engine->make();

        $should = array(
            array(
                'id' => 'foo',
            )
        );
        $this->assertEquals($should, $engine->getArray());
    }

    public function testComplex()
    {
        $engine = new CollectionEngine(new Collection($this->getRealArray()));
        $this->addRealColumns($engine);
        $engine->searchColumns('foo','bar');
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 't'
            )
        );

        $test = json_decode($engine->make()->getContent());
        $test = $test->aaData;

        $this->assertTrue($this->arrayHasKeyValue('foo','Nils',(array) $test));
        $this->assertTrue($this->arrayHasKeyValue('foo','Taylor',(array) $test));

        //Test2
        $engine = new CollectionEngine(new Collection($this->getRealArray()));
        $this->addRealColumns($engine);
        $engine->searchColumns('foo','bar');
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 'plasch'
            )
        );

        $test = json_decode($engine->make()->getContent());
        $test = $test->aaData;

        $this->assertTrue($this->arrayHasKeyValue('foo','Nils',(array) $test));
        $this->assertFalse($this->arrayHasKeyValue('foo','Taylor',(array) $test));

        //test3
        $engine = new CollectionEngine(new Collection($this->getRealArray()));
        $this->addRealColumns($engine);
        $engine->searchColumns('foo','bar');
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 'tay'
            )
        );

        $test = json_decode($engine->make()->getContent());
        $test = $test->aaData;



        $this->assertFalse($this->arrayHasKeyValue('foo','Nils',(array) $test));
        $this->assertTrue($this->arrayHasKeyValue('foo','Taylor',(array) $test));

        //test4
        $engine = new CollectionEngine(new Collection($this->getRealArray()));
        $this->addRealColumns($engine);
        $engine->searchColumns('foo','bar');
        $engine->setAliasMapping();

        Input::replace(
            array(
                'sSearch' => 'O'
            )
        );

        $test = json_decode($engine->make()->getContent());
        $test = $test->aaData;

        $this->assertFalse($this->arrayHasKeyValue('foo','Nils',(array) $test));
        $this->assertTrue($this->arrayHasKeyValue('foo','Taylor',(array) $test));

    }

    protected function tearDown()
    {
        Mockery::close();
    }

    private function getTestArray()
    {
        return array(
            array(
                'id' => 'foo'
            ),
            array(
                'id' => 'eoo'
            )
        );
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

    private function getTestColumns()
    {
        return new FunctionColumn('id', function($row){return $row['id'];});
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