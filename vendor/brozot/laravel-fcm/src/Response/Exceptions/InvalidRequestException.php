<?php

namespace LaravelFCM\Response\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

/**
 * Class InvalidRequestException.
 */
class InvalidRequestException extends Exception
{
    /**
     * InvalidRequestException constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $code = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();

        parent::__construct($responseBody, $code);
    }
}
