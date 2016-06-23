<?php namespace Chumper\Datatable\Columns;

class FunctionColumn extends BaseColumn {

    private $callable;

    function __construct($name, $callable)
    {
        parent::__construct($name);
        $this->callable = $callable;
    }

    public function run($model)
    {
        return call_user_func($this->callable,$model);
    }
}