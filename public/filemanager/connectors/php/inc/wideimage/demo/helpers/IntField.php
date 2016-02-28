<?php

    class IntField extends Field
    {
        public function __construct($name, $default, $hint = 'Integer')
        {
            parent::__construct($name, $default, $hint);
        }

        public function init($request)
        {
            $this->value = $request->getInt($this->name, $this->default);
        }
    }
