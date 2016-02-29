<?php

    class Demo_flip extends Demo
    {
        public $order = 1200;

        public function execute($image, $request)
        {
            return $image->flip();
        }
    }
