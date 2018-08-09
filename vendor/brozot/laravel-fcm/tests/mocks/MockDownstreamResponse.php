<?php

namespace LaravelFCM\Mocks;

use LaravelFCM\Response\DownstreamResponse;
use LaravelFCM\Response\DownstreamResponseContract;

/**
 * Class MockDownstreamResponse **Only use it for testing**.
 */
class MockDownstreamResponse implements DownstreamResponseContract
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
     * @var
     */
    protected $messageId;

    /**
     * @internal
     *
     * @var array
     */
    protected $tokensToDelete = [];

    /**
     * @internal
     *
     * @var array
     */
    protected $tokensToModify = [];
    /**
     * @internal
     *
     * @var array
     */
    protected $tokensToRetry = [];

    /**
     * @internal
     *
     * @var array
     */
    protected $tokensWithError = [];

    /**
     * @internal
     *
     * @var bool
     */
    protected $hasMissingToken = false;

    /**
     * DownstreamResponse constructor.
     *
     * @param $numberSuccess
     */
    public function __construct($numberSuccess)
    {
        $this->numberTokensSuccess = $numberSuccess;
    }

    /**
     * Not using it.
     *
     * @param DownstreamResponse $response
     *
     * @throws \Exception
     */
    public function merge(DownstreamResponse $response)
    {
        throw new \Exception('You cannot use this method for mocking response');
    }

    /**
     * Get the number of device reached with success + numberTokenToModify.
     *
     * @return int
     */
    public function numberSuccess()
    {
        return $this->numberTokensSuccess + count($this->tokensToModify);
    }

    /**
     * Get the number of device which thrown an error.
     *
     * @return int
     */
    public function numberFailure()
    {
        return count($this->tokensToDelete()) + count($this->tokensWithError);
    }

    /**
     * Get the number of device that you need to modify their token.
     *
     * @return int
     */
    public function numberModification()
    {
        return count($this->tokensToModify());
    }

    /**
     * Add a token to delete.
     *
     * @param $token
     * @return MockDownstreamResponse
     */
    public function addTokenToDelete($token)
    {
        $this->tokensToDelete[] = $token;
        return $this;
    }

    /**
     * get token to delete
     * remove all tokens returned by this method in your database.
     *
     * @return array
     */
    public function tokensToDelete()
    {
        return $this->tokensToDelete;
    }

    /**
     * Add a token to modify.
     *
     * @param $oldToken
     * @param $newToken
     * @return MockDownstreamResponse
     */
    public function addTokenToModify($oldToken, $newToken)
    {
        $this->tokensToModify[$oldToken] = $newToken;
        return $this;
    }

    /**
     * get token to modify
     * key: oldToken
     * value: new token
     * find the old token in your database and replace it with the new one.
     *
     * @return array
     */
    public function tokensToModify()
    {
        return $this->tokensToModify;
    }

    /**
     * Add a token to retry.
     *
     * @param $token
     * @return MockDownstreamResponse
     */
    public function addTokenToRetry($token)
    {
        $this->tokensToRetry[] = $token;
        return $this;
    }

    /**
     * Get tokens that you should resend using exponential backoof.
     *
     * @return array
     */
    public function tokensToRetry()
    {
        return $this->tokensToRetry;
    }

    /**
     * Add a token to errors.
     *
     * @param $token
     * @param $message
     * @return MockDownstreamResponse
     */
    public function addTokenWithError($token, $message)
    {
        $this->tokensWithError[$token] = $message;
        return $this;
    }

    /**
     * Get tokens that thrown an error
     * key : token
     * value : error
     * In production, remove these tokens from you database.
     *
     * @return array
     */
    public function tokensWithError()
    {
        return $this->tokensWithError;
    }

    /**
     * change missing token state.
     *
     * @param $hasMissingToken
     * @return MockDownstreamResponse
     */
    public function setMissingToken($hasMissingToken)
    {
        $this->hasMissingToken = $hasMissingToken;
        return $this;
    }

    /**
     * check if missing tokens was given to the request
     * If true, remove all the empty token in your database.
     *
     * @return bool
     */
    public function hasMissingToken()
    {
        return $this->hasMissingToken;
    }
}
