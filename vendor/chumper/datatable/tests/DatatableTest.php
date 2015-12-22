<?php

use Chumper\Datatable\Datatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class DatatableTest extends \Orchestra\Testbench\TestCase {

    /**
     * @var Datatable
     */
    private $dt;

    public function setUp()
    {
        parent::setUp();
        // set up config
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("chumper.datatable.engine")->andReturn(
            array(
                'exactWordSearch' => false,
            )
        );
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("chumper.datatable.classmap.QueryEngine",NULL)->andReturn('Chumper\Datatable\Engines\QueryEngine');
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("chumper.datatable.classmap.CollectionEngine",NULL)->andReturn('Chumper\Datatable\Engines\CollectionEngine');
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("chumper.datatable.classmap.Table",NULL)->andReturn('Chumper\Datatable\Table');
        
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("chumper.datatable.table")->andReturn(
            array(
                'class' => 'table table-bordered',
                'id' => '',
                'options' => array(
                    "sPaginationType" => "full_numbers",
                    "bProcessing" => false
                ),
                'callbacks' => array(),
                'noScript' => false,
                'table_view' => 'datatable::template',
                'script_view' => 'datatable::javascript',
            )
        );

        $this->dt = new Datatable;
        $this->mock = Mockery::mock('Illuminate\Database\Query\Builder');
    }

    public function testReturnInstances()
    {
        $api = $this->dt->query($this->mock);

        $this->assertInstanceOf('Chumper\Datatable\Engines\QueryEngine', $api);

        $api = $this->dt->collection(new Collection());

        $this->assertInstanceOf('Chumper\Datatable\Engines\CollectionEngine', $api);

        $table = $this->dt->table();

        $this->assertInstanceOf('Chumper\Datatable\Table', $table);
    }

}
