<?php namespace Chumper\Datatable\Columns;

class TextColumn extends BaseColumn {

    private $text;

    function __construct($name, $text)
    {
        parent::__construct($name);
        $this->text = $text;
    }

    public function run($model)
    {
        return $this->text;
    }
}
