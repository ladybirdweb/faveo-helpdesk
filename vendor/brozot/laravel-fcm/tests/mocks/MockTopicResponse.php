<?php

namespace LaravelFCM\Mocks;

use LaravelFCM\Response\TopicResponseContract;

/**
 * Class MockTopicResponse **Only use it for testing**.
 */
class MockTopicResponse implements TopicResponseContract
{
    /**
     * @internal
     *
     * @var string
     */
    protected $topic;

    /**
     * @internal
     *
     * @var string
     */
    protected $messageId;

    /**
     * @internal
     *
     * @var string
     */
    protected $error;

    /**
     * @internal
     *
     * @var bool
     */
    protected $needRetry = false;

    /**
     * if success set a message id.
     *
     * @param $messageId
     */
    public function setSuccess($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * true if topic sent with success.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return  (bool) $this->messageId;
    }

    /**
     * set error.
     *
     * @param $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * return error message
     * you should test if it's necessary to resent it.
     *
     * @return string error
     */
    public function error()
    {
        $this->error;
    }

    /**
     * return true if it's necessary resent it using exponential backoff.
     *
     * @return bool
     */
    public function shouldRetry()
    {
        $this->error;
    }
}
