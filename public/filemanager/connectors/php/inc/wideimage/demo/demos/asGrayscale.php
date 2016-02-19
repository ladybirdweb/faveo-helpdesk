<?php
    /**
     */
    class Demo_asGrayscale extends Demo
    {
        public $order = 300;

        public function execute($img, $request)
        {
            return $img->asGrayscale();
        }
    }
