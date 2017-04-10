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
     * set number of success.
     *
     * @param $numberSuccess
     */
    public function setNumberSuccess($numberSuccess)
    {
        $this->numberTokensSuccess = $numberSuccess;
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
     */
    public function setNumberFailure($numberFailures)
    {
        $this->numberTokensSuccess = $numberFailures;
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
     */
    public function addTokenFailed($tokenFailed)
    {
        $this->tokensFailed[] = $tokenFailed;
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
}
