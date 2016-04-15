<?php

namespace mjanssen\BreadcrumbsBundle\package;

class SingleBreadcrumb {

    public $name, $url, $crumb;

    public $uppercaseFirst;

    public function __construct($setName, $setUrl)
    {
        $config = config('breadcrumbs');

        $this->uppercaseFirst = (isset($config['uppercaseFirst'])) ? $config['uppercaseFirst'] : true;

        $this->name = ($this->uppercaseFirst === true) ? ucfirst($setName) : lcfirst($setName);
        $this->url = $setUrl;

        $this->crumb = '<a href="'.$this->url.'">'. $this->name.'</a>';
    }
}