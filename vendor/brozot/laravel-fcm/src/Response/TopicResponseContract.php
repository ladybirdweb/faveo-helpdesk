<?php

namespace LaravelFCM\Response;

/**
 * Interface TopicResponseContract.
 */
interface TopicResponseContract
{
    /**
     * true if topic sent with success.
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * return error message
     * you should test if it's necessary to resent it.
     *
     * @return string error
     */
    public function error();

    /**
     * return true if it's necessary resent it using exponential backoff.
     *
     * @return bool
     */
    public function shouldRetry();
}
