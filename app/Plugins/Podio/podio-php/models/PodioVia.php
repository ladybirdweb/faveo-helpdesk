<?php

class PodioVia extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('id', 'integer');
        $this->property('auth_client_id', 'integer');
        $this->property('name', 'string');
        $this->property('url', 'string');
        $this->property('display', 'boolean');

        $this->init($attributes);
    }
}
