<?php
    /**
     */
    class AngleField extends IntField
    {
        public function __construct($name, $default, $hint = 'In degrees clockwise, negative values accepted')
        {
            parent::__construct($name, $default, $hint);
        }
    }
