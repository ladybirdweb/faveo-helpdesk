<?php

    class Demo_addNoise extends Demo
    {
        public $order = 9350;

        public function init()
        {
            $this->addField(new IntField('amount', 300));
            $this->addField(new SelectField('type', ['salt&pepper', 'mono', 'color'], 'mono'));
        }

        public function execute($image, $request)
        {
            return $image->addNoise($this->fields['amount']->value, $this->fields['type']->value);
        }
    }
