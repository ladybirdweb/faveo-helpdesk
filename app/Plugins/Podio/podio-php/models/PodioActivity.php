<?php
/**
 * @see https://developers.podio.com/doc/stream
 */
class PodioActivity extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('id', 'integer');
        $this->property('type', 'string');
        $this->property('activity_type', 'string');
        $this->property('data', 'hash');
        $this->property('created_on', 'datetime');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('created_via', 'Via');

        $this->init($attributes);
    }
}
