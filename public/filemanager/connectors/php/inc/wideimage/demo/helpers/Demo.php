<?php

    class Demo
    {
        public $name;
        public $format = null;
        public $fields = [];
        public $order = 1000;

        public function __construct($name)
        {
            $this->name = $name;
        }

        public function init()
        {
        }

        public static function create($name)
        {
            $file = DEMO_PATH.'/demos/'.$name.'.php';
            if (!file_exists($file)) {
                throw new Exception("Invalid demo: {$name}");
            }
            include $file;
            $className = 'Demo_'.$name;
            $demo = new $className($name);
            $demo->request = Request::getInstance();
            $demo->init();
            foreach ($demo->fields as $field) {
                $field->request = Request::getInstance();
                $field->init(Request::getInstance());
            }

            return $demo;
        }

        public function getFormat()
        {
            return 'as input';
        }

        public function addField($field)
        {
            $this->fields[$field->name] = $field;
        }

        public function __toString()
        {
            return $this->name;
        }

        public function text()
        {
        }

        public function fval($name)
        {
            return $this->fields[$name]->value;
        }
    }
