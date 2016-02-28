<?php

    class FormatSelectField extends SelectField
    {
        public function __construct($name)
        {
            parent::__construct($name, ['preset for demo', 'as input', 'png8', 'png24', 'jpeg', 'gif', 'bmp'], null, 'Image format');
        }
    }
