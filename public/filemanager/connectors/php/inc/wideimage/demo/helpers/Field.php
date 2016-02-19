<?php
    /**
     */
    class Field
    {
        public $name;
        public $default;
        public $value;
        public $request;
        public $hint;

        public function __construct($name, $default = null, $hint = '')
        {
            $this->name = $name;
            $this->default = $default;

            if ($hint == '') {
                $hint = $name;
            }

            $this->hint = $hint;
        }

        public function init($request)
        {
            $this->value = $request->get($this->name, $this->default);
        }

        public function render()
        {
            $id = htmlentities($this->name);
            echo '<label style="background-color: #c0c0c0; padding: 5px; margin: 2px;" for="imgparam_'.$id.'" title="'.htmlentities($this->hint).'">';
            echo $this->name.': ';
            $this->renderBody($id, 'imgparam_'.$id);
            echo '</label> ';
        }

        public function renderBody($name, $id)
        {
            echo '<input id="'.$id.'" type="text" size="15" name="'.$name.'" value="'.$this->getRenderValue().'" />';
        }

        public function getRenderValue()
        {
            return $this->value;
        }

        public function getUrlValue()
        {
            return urlencode($this->name).'='.urlencode($this->value);
        }
    }
