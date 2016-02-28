<?php

    class FloatField extends Field
    {
        public function __construct($name, $default, $hint = 'Float')
        {
            parent::__construct($name, $default, $hint);
        }

        public function init($request)
        {
            $this->value = $request->getFloat($this->name, $this->default);
        }
    }
