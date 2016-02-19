<?php
    /**
     */
    class Demo_getMask extends Demo
    {
        public $order = 550;

        public function execute($img, $request)
        {
            return $img->getMask();
        }
    }
