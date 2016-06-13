<?php

namespace MaxMind\Exception;

/**
 * Thrown when a MaxMind web service returns an error relating to the request.
 */
class InvalidRequestException extends HttpException
{
    /**
     * The code returned by the MaxMind web service
     */
    private $error;

    /**
     * @param string $message The exception message
     * @param int $error The error code returned by the MaxMind web service
     * @param int $httpStatus The HTTP status code of the response
     * @param string $uri The URI queries
     * @param \Exception $previous The previous exception, if any.
     */
    public function __construct(
        $message,
        $error,
        $httpStatus,
        $uri,
        \Exception $previous = null
    ) {
        $this->error = $error;
        parent::__construct($message, $httpStatus, $uri, $previous);
    }

    public function getErrorCode()
    {
        return $this->error;
    }
}
