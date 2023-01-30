<?php

use Chumper\Datatable\Datatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class DatatableTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Datatable
     */
    private $dt;

    protected function setUp()
    {
        // set up config
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("datatable::engine")->andReturn(
            array(
                'exactWordSearch' => false,
            )
        );
        Config::shouldReceive('get')->zeroOrMoreTimes()->with("datatable::table")->andReturn(
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
