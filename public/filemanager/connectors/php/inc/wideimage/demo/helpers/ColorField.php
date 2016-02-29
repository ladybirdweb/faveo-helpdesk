<?php

    class ColorField extends Field
    {
        public function __construct($name, $default, $hint = 'RRGGBB hex, leave blank for transparent background')
        {
            parent::__construct($name, $default, $hint);
        }

        public function init($request)
        {
            $c = $request->getColor($this->name, $this->default);
            if ($c === '') {
                $this->value = null;
            } else {
                $this->value = str_pad(dechex(hexdec($c)), 6, '0', STR_PAD_LEFT);
            }
        }

        public function getRenderValue()
        {
            return $this->value;
        }
    }
