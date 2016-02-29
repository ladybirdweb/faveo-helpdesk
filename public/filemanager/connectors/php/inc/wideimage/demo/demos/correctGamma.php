<?php

    class Demo_correctGamma extends Demo
    {
        public $order = 2050;

        public function init()
        {
            $this->addField(new FloatField('in_gamma', 1.1));
            $this->addField(new FloatField('out_gamma', 3.7));
        }

        public function execute($image, $request)
        {
            return $image->correctGamma($this->fval('in_gamma'), $this->fval('out_gamma'));
        }
    }
