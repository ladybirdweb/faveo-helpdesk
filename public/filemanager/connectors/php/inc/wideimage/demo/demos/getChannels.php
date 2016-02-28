<?php

    class Demo_getChannels extends Demo
    {
        public $order = 500;

        protected $channels = ['red', 'green', 'blue', 'alpha'];

        public function init()
        {
            $this->addField(new CheckboxField('red', true));
            $this->addField(new CheckboxField('green', false));
            $this->addField(new CheckboxField('blue', true));
            $this->addField(new CheckboxField('alpha', false));
        }

        public function execute($img, $request)
        {
            $on = [];
            foreach ($this->channels as $name) {
                if ($this->fields[$name]->value) {
                    $on[] = $name;
                }
            }

            return $img->getChannels($on);
        }
    }
