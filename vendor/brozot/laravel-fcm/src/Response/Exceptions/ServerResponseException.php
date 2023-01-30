<?php

namespace LaravelFCM\Response\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ServerResponseException.
 */
class ServerResponseException extends Exception
{
    /**
     * retry after.
     *
     * @var int
     */
    public $retryAfter;

    /**
     * ServerResponseException constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $code = $response->getStatusCode();
        $responseHeader = $response->getHeaders();
        $responseBody = $response->getBody()->getContents();

        if (array_keys($responseHeader, 'Retry-After')) {
            $this->retryAfter = $responseHeader['Retry-After'];
        }

        parent::__construct($responseBody, $code);
    }
}
