<?php namespace LaravelFCM\Response\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Class UnauthorizedRequestException
 *
 * @package LaravelFCM\Response\Exceptions
 */
class UnauthorizedRequestException extends Exception {

	/**
	 * UnauthorizedRequestException constructor.
	 *
	 * @param GuzzleResponse $response
	 */
	public function __construct(GuzzleResponse $response)
	{
		$code = $response->getStatusCode();

		parent::__construct('FCM_SENDER_ID or FCM_SERVER_KEY are invalid', $code);
	}
}