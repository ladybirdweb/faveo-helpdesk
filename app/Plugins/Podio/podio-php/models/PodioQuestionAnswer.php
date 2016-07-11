<?php
/**
 * @see https://developers.podio.com/doc/questions
 */
class PodioQuestionAnswer extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('question_option_id', 'integer', ['id' => true]);

        $this->has_one('user', 'Contact');

        $this->init($attributes);
    }
}
