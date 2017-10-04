<?php

namespace LaravelFCM\Mocks;

use LaravelFCM\Response\GroupResponseContract;

/**
 * Class MockGroupResponse **Only use it for testing**.
 */
class MockGroupResponse implements GroupResponseContract
{
    /**
     * @internal
     *
     * @var int
     */
    protected $numberTokensSuccess = 0;

    /**
     * @internal
     *
     * @var int
     */
    protected $numberTokensFailure = 0;

    /**
     * @internal
     *
     * @var array
     */
    protected $tokensFailed = [];

    /**
     * @internal
     *
     * @var string
     */
    protected $to;

    /**
     * set number of success.
     *
     * @param int $numberSuccess
     * @return MockGroupResponse
     */
    public function setNumberSuccess($numberSuccess)
    {
        $this->numberTokensSuccess = $numberSuccess;
        return $this;
    }

    /**
     * Get the number of device reached with success.
     *
     * @return int
     */
    public function numberSuccess()
    {
        return $this->numberTokensSuccess;
    }

    /**
     * set number of failures.
     *
     * @param $numberFailures
     * @return MockGroupResponse
     */
    public function setNumberFailure($numberFailures)
    {
        $this->numberTokensSuccess = $numberFailures;
        return $this;
    }

    /**
     * Get the number of device which thrown an error.
     *
     * @return int
     */
    public function numberFailure()
    {
        return $this->numberTokensFailure;
    }

    /**
     * add a token to the failed list.
     *
     * @param $tokenFailed
     * @return MockGroupResponse
     */
    public function addTokenFailed($tokenFailed)
    {
        $this->tokensFailed[] = $tokenFailed;
        return $this;
    }

    /**
     * Get all token in group that fcm cannot reach.
     *
     * @return array
     */
    public function tokensFailed()
    {
        return $this->tokensFailed;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     * @return MockGroupResponse
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }
}
