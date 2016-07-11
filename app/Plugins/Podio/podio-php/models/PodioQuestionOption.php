<?php
/**
 * @see https://developers.podio.com/doc/questions
 */
class PodioQuestionOption extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('question_option_id', 'integer', ['id' => true]);
        $this->property('text', 'string');

        $this->init($attributes);
    }
}
