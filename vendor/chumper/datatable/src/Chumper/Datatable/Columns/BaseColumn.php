<?php namespace Chumper\Datatable\Columns;

/**
 * Class BaseColumn
 * @package Chumper\Datatable\Columns
 */
abstract class BaseColumn {

    /**
     * @var String name of the column
     */
    protected $name;

    /**
     * @param $name
     */
    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $model The data to pass to the column,
     *              could be a model or an array
     * @return mixed the return value of the implementation,
     *              should be text in most of the cases
     */
    public abstract function run($model);

    /**
     * @return String The name of the column
     */
    public function getName()
    {
        return $this->name;
    }
}
