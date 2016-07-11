<?php

class PodioByLine extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('type', 'string');
        $this->property('id', 'integer');
        $this->property('avatar_type', 'string');
        $this->property('avatar_id', 'integer');
        $this->property('image', 'hash');
        $this->property('name', 'string');
        $this->property('url', 'string');
        $this->property('avatar', 'integer'); // Legacy

    $this->init($attributes);
    }
}
