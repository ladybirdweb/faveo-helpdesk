<?php namespace Chumper\Datatable;

use Chumper\Datatable\Engines\CollectionEngine;
use Chumper\Datatable\Engines\QueryEngine;
use Input;
use Request;

/**
 * Class Datatable
 * @package Chumper\Datatable
 */
class Datatable {

    private $columnNames = array();

    /**
     * @param $query
     * @return \Chumper\Datatable\Engines\QueryEngine
     */
    public function query($query)
    {
        $class = config('chumper.datatable.classmap.QueryEngine');
        return new $class($query);
    }

    /**
     * @param $collection
     * @return \Chumper\Datatable\Engines\CollectionEngine
     */
    public function collection($collection)
    {
        $class = config('chumper.datatable.classmap.CollectionEngine');
        return new $class($collection);
    }

    /**
     * @return \Chumper\Datatable\Table
     */
    public function table()
    {
        $class = config('chumper.datatable.classmap.Table');
        return new $class();
    }

    /**
     * @return bool True if the plugin should handle this request, false otherwise
     */
    public function shouldHandle()
    {
        $echo = Input::get('sEcho',null);
        if(/*Request::ajax() && */!is_null($echo) && is_numeric($echo))
        {
            return true;
        }
        return false;
    }
}