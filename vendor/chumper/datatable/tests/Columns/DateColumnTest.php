<?php namespace Chumper\Datatable\Columns;

use Carbon\Carbon;
use Mockery;

class DateColumnTest extends \PHPUnit_Framework_TestCase {

    public function testAll()
    {
        $c = Mockery::mock('Carbon\Carbon');

        $column1 = new DateColumn('foo', DateColumn::DATE, 'foo');
        $c->shouldReceive('toDateString')
            ->withNoArgs()->once()
            ->andReturn('fooBar');

        $column2 = new DateColumn('foo', DateColumn::TIME, 'foo');
        $c->shouldReceive('toTimeString')
            ->withNoArgs()->once()
            ->andReturn('fooBar');

        $column3 = new DateColumn('foo', DateColumn::DATE_TIME, 'foo');
        $c->shouldReceive('toDateTimeString')
            ->withNoArgs()->once()
            ->andReturn('fooBar');

        $column4 = new DateColumn('foo', DateColumn::CUSTOM, 'foo');
        $c->shouldReceive('format')
            ->with('foo')->once()
            ->andReturn('fooBar');

        $column5 = new DateColumn('foo', DateColumn::FORMATTED_DATE, 'foo');
        $c->shouldReceive('toFormattedDateString')
            ->withNoArgs()->once()
            ->andReturn('fooBar');

        $column6 = new DateColumn('foo', DateColumn::DAY_DATE, 'foo');
        $c->shouldReceive('toDayDateTimeString')
            ->withNoArgs()->once()
            ->andReturn('fooBar');

        //now test
        $this->assertEquals('fooBar', $column1->run(array('foo' => $c)));
        $this->assertEquals('fooBar', $column2->run(array('foo' => $c)));
        $this->assertEquals('fooBar', $column3->run(array('foo' => $c)));
        $this->assertEquals('fooBar', $column4->run(array('foo' => $c)));
        $this->assertEquals('fooBar', $column5->run(array('foo' => $c)));
        $this->assertEquals('fooBar', $column6->run(array('foo' => $c)));
    }

    protected function tearDown()
    {
        Mockery::close();
    }
}
 