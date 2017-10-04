<?php

namespace LaravelFCM\Response;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GroupResponse.
 */
class GroupResponse extends BaseResponse implements GroupResponseContract
{
    const FAILED_REGISTRATION_IDS = 'failed_registration_ids';

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
     * GroupResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                $to
     */
    public function __construct(ResponseInterface $response, $to)
    {
        $this->to = $to;
        parent::__construct($response);
    }

    /**
     * parse the response.
     *
     * @param $responseInJson
     */
    protected function parseResponse($responseInJson)
    {
        if ($this->parse($responseInJson)) {
            $this->parseFailed($responseInJson);
        }

        if ($this->logEnabled) {
            $this->logResponse();
        }
    }

    /**
     * Log the response.
     */
    protected function logResponse()
    {
        $logger = new Logger('Laravel-FCM');
        $logger->pushHandler(new StreamHandler(storage_path('logs/laravel-fcm.log')));

        $logMessage = "notification send to group: $this->to";
        $logMessage .= "with $this->numberTokensSuccess success and $this->numberTokensFailure";

        $logger->info($logMessage);
    }

    /**
     * @internal
     *
     * @param $responseInJson
     *
     * @return bool
     */
    private function parse($responseInJson)
    {
        if (array_key_exists(self::SUCCESS, $responseInJson)) {
            $this->numberTokensSuccess = $responseInJson[self::SUCCESS];
        }
        if (array_key_exists(self::FAILURE, $responseInJson)) {
            $this->numberTokensFailure = $responseInJson[self::FAILURE];
        }

        return $this->numberTokensFailure > 0;
    }

    /**
     * @internal
     *
     * @param $responseInJson
     */
    private function parseFailed($responseInJson)
    {
        if (array_key_exists(self::FAILED_REGISTRATION_IDS, $responseInJson)) {
            foreach ($responseInJson[self::FAILED_REGISTRATION_IDS] as $registrationId) {
                $this->tokensFailed[] = $registrationId;
            }
        }
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
     * Get all token in group that fcm cannot reach.
     *
     * @return array
     */
    public function tokensFailed()
    {
        return $this->tokensFailed;
    }
}
