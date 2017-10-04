<?php

namespace LaravelFCM\Response;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DownstreamResponse.
 */
class DownstreamResponse extends BaseResponse implements DownstreamResponseContract
{
    const MULTICAST_ID = 'multicast_id';
    const CANONICAL_IDS = 'canonical_ids';
    const RESULTS = 'results';

    const MISSING_REGISTRATION = 'MissingRegistration';
    const MESSAGE_ID = 'message_id';
    const REGISTRATION_ID = 'registration_id';
    const NOT_REGISTERED = 'NotRegistered';
    const INVALID_REGISTRATION = 'InvalidRegistration';
    const UNAVAILABLE = 'Unavailable';
    const DEVICE_MESSAGE_RATE_EXCEEDED = 'DeviceMessageRateExceeded';
    const INTERNAL_SERVER_ERROR = 'InternalServerError';

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
     * @var int
     */
    protected $numberTokenModify = 0;

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
     * @internal
     *
     * @var array
     */
    private $tokens;

    /**
     * DownstreamResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                $tokens
     */
    public function __construct(ResponseInterface $response, $tokens)
    {
        $this->tokens = is_string($tokens) ? [$tokens] : $tokens;

        parent::__construct($response);
    }

    /**
     * Parse the response.
     *
     * @param $responseInJson
     */
    protected function parseResponse($responseInJson)
    {
        $this->parse($responseInJson);

        if ($this->needResultParsing($responseInJson)) {
            $this->parseResult($responseInJson);
        }

        if ($this->logEnabled) {
            $this->logResponse();
        }
    }

    /**
     * @internal
     *
     * @param $responseInJson
     */
    private function parse($responseInJson)
    {
        if (array_key_exists(self::MULTICAST_ID, $responseInJson)) {
            $this->messageId;
        }

        if (array_key_exists(self::SUCCESS, $responseInJson)) {
            $this->numberTokensSuccess = $responseInJson[self::SUCCESS];
        }

        if (array_key_exists(self::FAILURE, $responseInJson)) {
            $this->numberTokensFailure = $responseInJson[self::FAILURE];
        }

        if (array_key_exists(self::CANONICAL_IDS, $responseInJson)) {
            $this->numberTokenModify = $responseInJson[self::CANONICAL_IDS];
        }
    }

    /**
     * @internal
     *
     * @param $responseInJson
     */
    private function parseResult($responseInJson)
    {
        foreach ($responseInJson[self::RESULTS] as $index => $result) {
            if (!$this->isSent($result)) {
                if (!$this->needToBeModify($index, $result)) {
                    if (!$this->needToBeDeleted($index, $result) && !$this->needToResend($index, $result) && !$this->checkMissingToken($result)) {
                        $this->needToAddError($index, $result);
                    }
                }
            }
        }
    }

    /**
     * @internal
     *
     * @param $responseInJson
     *
     * @return bool
     */
    private function needResultParsing($responseInJson)
    {
        return array_key_exists(self::RESULTS, $responseInJson) && ($this->numberTokensFailure > 0 || $this->numberTokenModify > 0);
    }

    /**
     * @internal
     *
     * @param $results
     *
     * @return bool
     */
    private function isSent($results)
    {
        return array_key_exists(self::MESSAGE_ID, $results) && !array_key_exists(self::REGISTRATION_ID, $results);
    }

    /**
     * @internal
     *
     * @param $index
     * @param $result
     *
     * @return bool
     */
    private function needToBeModify($index, $result)
    {
        if (array_key_exists(self::MESSAGE_ID, $result) && array_key_exists(self::REGISTRATION_ID, $result)) {
            if ($this->tokens[$index]) {
                $this->tokensToModify[$this->tokens[$index]] = $result[self::REGISTRATION_ID];
            }

            return true;
        }

        return false;
    }

    /**
     * @internal
     *
     * @param $index
     * @param $result
     *
     * @return bool
     */
    private function needToBeDeleted($index, $result)
    {
        if (array_key_exists(self::ERROR, $result) &&
            (in_array(self::NOT_REGISTERED, $result) || in_array(self::INVALID_REGISTRATION, $result))) {
            if ($this->tokens[$index]) {
                $this->tokensToDelete[] = $this->tokens[$index];
            }

            return true;
        }

        return false;
    }

    /**
     * @internal
     *
     * @param $index
     * @param $result
     *
     * @return bool
     */
    private function needToResend($index, $result)
    {
        if (array_key_exists(self::ERROR, $result) && (in_array(self::UNAVAILABLE, $result) || in_array(self::DEVICE_MESSAGE_RATE_EXCEEDED, $result) || in_array(self::INTERNAL_SERVER_ERROR, $result))) {
            if ($this->tokens[$index]) {
                $this->tokensToRetry[] = $this->tokens[$index];
            }

            return true;
        }

        return false;
    }

    /**
     * @internal
     *
     * @param $result
     *
     * @return bool
     */
    private function checkMissingToken($result)
    {
        $hasMissingToken = (array_key_exists(self::ERROR, $result) && in_array(self::MISSING_REGISTRATION, $result));

        $this->hasMissingToken = (bool) ($this->hasMissingToken | $hasMissingToken);

        return $hasMissingToken;
    }

    /**
     * @internal
     *
     * @param $index
     * @param $result
     */
    private function needToAddError($index, $result)
    {
        if (array_key_exists(self::ERROR, $result)) {
            if ($this->tokens[$index]) {
                $this->tokensWithError[$this->tokens[$index]] = $result[self::ERROR];
            }
        }
    }

    /**
     * @internal
     */
    protected function logResponse()
    {
        $logger = new Logger('Laravel-FCM');
        $logger->pushHandler(new StreamHandler(storage_path('logs/laravel-fcm.log')));

        $logMessage = 'notification send to '.count($this->tokens).' devices'.PHP_EOL;
        $logMessage .= 'success: '.$this->numberTokensSuccess.PHP_EOL;
        $logMessage .= 'failures: '.$this->numberTokensFailure.PHP_EOL;
        $logMessage .= 'number of modified token : '.$this->numberTokenModify.PHP_EOL;

        $logger->info($logMessage);
    }

    /**
     * Merge two response.
     *
     * @param DownstreamResponse $response
     */
    public function merge(DownstreamResponse $response)
    {
        $this->numberTokensSuccess += $response->numberSuccess();
        $this->numberTokensFailure += $response->numberFailure();
        $this->numberTokenModify += $response->numberModification();

        $this->tokensToDelete = array_merge($this->tokensToDelete, $response->tokensToDelete());
        $this->tokensToModify = array_merge($this->tokensToModify, $response->tokensToModify());
        $this->tokensToRetry = array_merge($this->tokensToRetry, $response->tokensToRetry());
        $this->tokensWithError = array_merge($this->tokensWithError, $response->tokensWithError());
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
     * Get the number of device which thrown an error.
     *
     * @return int
     */
    public function numberFailure()
    {
        return $this->numberTokensFailure;
    }

    /**
     * Get the number of device that you need to modify their token.
     *
     * @return int
     */
    public function numberModification()
    {
        return $this->numberTokenModify;
    }

    /**
     * get token to delete.
     *
     * remove all tokens returned by this method in your database
     *
     * @return array
     */
    public function tokensToDelete()
    {
        return $this->tokensToDelete;
    }

    /**
     * get token to modify.
     *
     * key: oldToken
     * value: new token
     *
     * find the old token in your database and replace it with the new one
     *
     * @return array
     */
    public function tokensToModify()
    {
        return $this->tokensToModify;
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
     * Get tokens that thrown an error.
     *
     * key : token
     * value : error
     *
     * In production, remove these tokens from you database
     *
     * @return array
     */
    public function tokensWithError()
    {
        return $this->tokensWithError;
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
