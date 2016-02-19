<?php
    /**
     */
    class Demo_asNegative extends Demo
    {
        public $order = 300;

        public function execute($img, $request)
        {
            return $img->asNegative();
        }
    }
