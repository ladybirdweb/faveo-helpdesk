<?php
    /**
     */
    class Demo_mirror extends Demo
    {
        public $order = 1150;

        public function execute($image, $request)
        {
            return $image->mirror();
        }
    }
