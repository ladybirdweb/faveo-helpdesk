<?php
    /**
     */
    class Demo_applyMask extends Demo
    {
        public $order = 600;

        public function init()
        {
            $this->addField(new FileSelectField('mask', 'masks'));
            $this->addField(new CoordinateField('left', 10));
            $this->addField(new CoordinateField('top', '30%'));

            if (!$this->request->get('mask')) {
                $this->request->set('mask', 'mask-circle.gif');
            }
        }

        public function execute($image)
        {
            $mask = WideImage::load(DEMO_PATH.'masks/'.$this->fields['mask']->value);
            $left = $this->fields['left']->value;
            $top = $this->fields['top']->value;

            return $image->applyMask($mask, $left, $top);
        }

        public function getFormat()
        {
            return 'png';
        }
    }
