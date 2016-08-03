<?php namespace LaravelFCM\Response;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use LaravelFCM\Response\Exceptions\ServerResponseException;
use LaravelFCM\Response\Exceptions\InvalidRequestException;
use LaravelFCM\Response\Exceptions\UnauthorizedRequestException;

/**
 * Class BaseResponse
 *
 * @package LaravelFCM\Response
 */
abstract class BaseResponse {

	const SUCCESS = 'success';
	const FAILURE = 'failure';
	const ERROR = "error";
	const MESSAGE_ID = "message_id";

	/**
	 * BaseResponse constructor.
	 *
	 * @param GuzzleResponse $response
	 */
	public function __construct(GuzzleResponse $response)
	{
		$this->isJsonResponse($response);

		$responseInJson = json_decode($response->getBody(), true);
		$this->parseResponse($responseInJson);
	}

	/**
	 * Check if the response given by fcm is parsable
	 *
	 * @param GuzzleResponse $response
	 *
	 * @throws InvalidRequestException
	 * @throws ServerResponseException
	 * @throws UnauthorizedRequestException
	 */
	private function isJsonResponse(GuzzleResponse $response)
	{
		if ($response->getStatusCode() == 200) {
			return;
		}

		if ($response->getStatusCode() == 400) {
			throw new InvalidRequestException($response);
		}

		if ($response->getStatusCode() == 401) {
			throw new UnauthorizedRequestException($response);
		}

		throw new ServerResponseException($response);
	}

	/**
	 * parse the response
	 *
	 * @param array $responseInJson
	 */
	protected abstract function parseResponse($responseInJson);

	/**
	 * Log the response
	 */
	protected abstract function logResponse();

}