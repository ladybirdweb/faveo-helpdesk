<?php namespace LaravelFCM\Response\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Class InvalidRequestException
 *
 * @package LaravelFCM\Response\Exceptions
 */
class InvalidRequestException extends Exception {

	/**
	 * InvalidRequestException constructor.
	 *
	 * @param GuzzleResponse $response
	 */
	public function __construct(GuzzleResponse $response)
	{
		$code = $response->getStatusCode();
		$responseBody = $response->getBody()->getContents();

		parent::__construct($responseBody, $code);
	}
}