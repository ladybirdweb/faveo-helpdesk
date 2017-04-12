<?php

namespace LaravelFCM\Message;

use Closure;
use LaravelFCM\Message\Exceptions\NoTopicProvidedException;

/**
 * Class Topics.
 *
 * Create topic or a topic condition
 */
class Topics
{
    /**
     * @internal
     *
     * @var array of element in the condition
     */
    public $conditions = [];

    /**
     * Add a topic, this method should be called before any conditional topic.
     *
     * @param string $first topicName
     *
     * @return $this
     */
    public function topic($first)
    {
        $this->conditions[] = compact('first');

        return $this;
    }

    /**
     * Add a or condition to the precedent topic set.
     *
     * Parenthesis is a closure
     *
     * Equivalent of this: **'TopicA' in topic' || 'TopicB' in topics**
     *
     * ```
     *          $topic = new Topics();
     *          $topic->topic('TopicA')
     *                ->orTopic('TopicB');
     * ```
     *
     * Equivalent of this: **'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)**
     *
     * ```
     *          $topic = new Topics();
     *          $topic->topic('TopicA')
     *                ->andTopic(function($condition) {
     *                      $condition->topic('TopicB')->orTopic('TopicC');
     *          });
     * ```
     *
     * > Note: Only two operators per expression are supported by fcm
     *
     * @param string|Closure $first topicName or closure
     *
     * @return Topics
     */
    public function orTopic($first)
    {
        return $this->on($first, ' || ');
    }

    /**
     * Add a and condition to the precedent topic set.
     *
     * Parenthesis is a closure
     *
     * Equivalent of this: **'TopicA' in topic' && 'TopicB' in topics**
     *
     * ```
     *          $topic = new Topics();
     *          $topic->topic('TopicA')
     *                ->anTopic('TopicB');
     * ```
     *
     * Equivalent of this: **'TopicA' in topics || ('TopicB' in topics && 'TopicC' in topics)**
     *
     * ```
     *          $topic = new Topics();
     *          $topic->topic('TopicA')
     *                ->orTopic(function($condition) {
     *                      $condition->topic('TopicB')->AndTopic('TopicC');
     *          });
     * ```
     *
     * > Note: Only two operators per expression are supported by fcm
     *
     * @param string|Closure $first topicName or closure
     *
     * @return Topics
     */
    public function andTopic($first)
    {
        return $this->on($first, ' && ');
    }

    /**
     * @internal
     *
     * @param $first
     * @param $condition
     *
     * @return $this|Topics
     */
    private function on($first, $condition)
    {
        if ($first instanceof Closure) {
            return $this->nest($first, $condition);
        }

        $this->conditions[] = compact('condition', 'first');

        return $this;
    }

    /**
     * @internal
     *
     * @param Closure $callback
     * @param         $condition
     *
     * @return $this
     */
    public function nest(Closure $callback, $condition)
    {
        $topic = new static();

        $callback($topic);
        if (count($topic->conditions)) {
            $open_parenthesis = '(';
            $topic = $topic->conditions;
            $close_parenthesis = ')';

            $this->conditions[] = compact('condition', 'open_parenthesis', 'topic', 'close_parenthesis');
        }

        return $this;
    }

    /**
     * Transform to array.
     *
     * @return array|string
     *
     * @throws NoTopicProvided
     */
    public function build()
    {
        $this->checkIfOneTopicExist();

        if ($this->hasOnlyOneTopic()) {
            foreach ($this->conditions[0] as $topic) {
                return '/topics/'.$topic;
            }
        }

        return [
            'condition' => $this->topicsForFcm($this->conditions),
        ];
    }

    /**
     * @internal
     *
     * @param $conditions
     *
     * @return string
     */
    private function topicsForFcm($conditions)
    {
        $condition = '';
        foreach ($conditions as $partial) {
            if (array_key_exists('condition', $partial)) {
                $condition .= $partial['condition'];
            }

            if (array_key_exists('first', $partial)) {
                $topic = $partial['first'];
                $condition .= "'$topic' in topics";
            }

            if (array_key_exists('open_parenthesis', $partial)) {
                $condition .= $partial['open_parenthesis'];
            }

            if (array_key_exists('topic', $partial)) {
                $condition .= $this->topicsForFcm($partial['topic']);
            }

            if (array_key_exists('close_parenthesis', $partial)) {
                $condition .= $partial['close_parenthesis'];
            }
        }

        return $condition;
    }

    /**
     * Check if only one topic was set.
     *
     * @return bool
     */
    public function hasOnlyOneTopic()
    {
        return count($this->conditions) == 1;
    }

    /**
     * @internal
     *
     * @throws NoTopicProvidedException
     */
    private function checkIfOneTopicExist()
    {
        if (!count($this->conditions)) {
            throw new NoTopicProvidedException('At least one topic must be provided');
        }
    }
}
