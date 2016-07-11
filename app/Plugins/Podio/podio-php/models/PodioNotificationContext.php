<?php
/**
 * @see https://developers.podio.com/doc/notifications
 */
class PodioNotificationContext extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('title', 'string');
        $this->property('data', 'hash');
        $this->property('comment_count', 'integer');

        $this->has_one('ref', 'Reference');
        $this->has_one('space', 'Space');
        $this->has_one('org', 'Organization');

        $this->init($attributes);
    }
}
