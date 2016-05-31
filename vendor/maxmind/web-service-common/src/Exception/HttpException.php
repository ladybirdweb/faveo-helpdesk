<?php

namespace MaxMind\Exception;

/**
 *  This class represents an HTTP transport error.
 */
class HttpException extends WebServiceException
{
    /**
     * The URI queried
     */
    private $uri;

    /**
     * @param string $message A message describing the error.
     * @param int $httpStatus The HTTP status code of the response
     * @param string $uri The URI used in the request.
     * @param \Exception $previous The previous exception, if any.
     */
    public function __construct(
        $message,
        $httpStatus,
        $uri,
        \Exception $previous = null
    ) {
        $this->uri = $uri;
        parent::__construct($message, $httpStatus, $previous);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getStatusCode()
    {
        return $this->getCode();
    }
}
