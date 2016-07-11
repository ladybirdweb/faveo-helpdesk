<?php
/**
 * @see https://developers.podio.com/doc/conversations
 */
class PodioConversationMessage extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('message_id', 'integer', ['id' => true]);
        $this->property('embed_id', 'integer');
        $this->property('embed_file_id', 'integer');
        $this->property('text', 'string');
        $this->property('created_on', 'datetime');

        $this->has_one('embed', 'Embed');
        $this->has_one('embed_file', 'File');
        $this->has_one('created_by', 'ByLine');
        $this->has_many('files', 'File');

        $this->init($attributes);
    }
}
