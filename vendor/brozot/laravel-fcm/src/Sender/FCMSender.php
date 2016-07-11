<?php namespace LaravelFCM\Sender;

use GuzzleHttp\Exception\ClientException;
use LaravelFCM\FCMRequest;
use LaravelFCM\Message\Options;
use LaravelFCM\Message\PayloadData;
use LaravelFCM\Message\PayloadNotification;
use \GuzzleHttp\Psr7\Response as GuzzleResponse;
use LaravelFCM\Message\Topics;
use LaravelFCM\Request\Request;
use LaravelFCM\Response\DownstreamResponse;
use LaravelFCM\Response\GroupResponse;
use LaravelFCM\Response\TopicResponse;

/**
 * Class FCMSender
 *
 * @package LaravelFCM\Sender
 */
class FCMSender extends BaseSender {

	const MAX_TOKEN_PER_REQUEST = 1000;

	/**
	 * send a downstream message to
	 *
	 * - a unique device with is registration Token
	 * - or to multiples devices with an array of registrationIds
	 *
	 * @param String|array             $to
	 * @param Options|null             $options
	 * @param PayloadNotification|null $notification
	 * @param PayloadData|null         $data
	 *
	 * @return DownstreamResponse|null
	 *
	 */
	public function sendTo($to, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$response = null;

		if (is_array($to)) {
			$partialTokens = array_chunk($to, self::MAX_TOKEN_PER_REQUEST, false);
			foreach ($partialTokens as $tokens) {
				$request = new Request($tokens, $options, $notification, $data);
				
				try {
					$responseGuzzle = $this->client->post($this->url, $request->build());
				}
				catch (ClientException $e) {
					$responseGuzzle = $e->getResponse();
				}

				$responsePartial = new DownstreamResponse($responseGuzzle, $tokens);
				if (!$response) {
					$response = $responsePartial;
				}
				else {
					$response->merge($responsePartial);
				}
			}
		}
		else {
			$request = new Request($to, $options, $notification, $data);
			$response = $this->client->post($this->url, $request->build());
			$response = new DownstreamResponse($response, $to);
		}

		return $response;
	}

	/**
	 * Send a message to a group of devices identified with them notification key
	 *
	 * @param                          $notificationKey
	 * @param Options|null             $options
	 * @param PayloadNotification|null $notification
	 * @param PayloadData|null         $data
	 *
	 * @return GroupResponse
	 */
	public function sendToGroup($notificationKey, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$request = new Request($notificationKey, $options, $notification, $data);

		try {
			$response = $this->client->post($this->url, $request->build());
		}
		catch (ClientException $e) {
			$response = $e->getResponse();
		}

		return new GroupResponse($response, $notificationKey);
	}

	/**
	 * Send message devices registered at a or more topics
	 *
	 * @param Topics                   $topics
	 * @param Options|null             $options
	 * @param PayloadNotification|null $notification
	 * @param PayloadData|null         $data
	 *
	 * @return TopicResponse
	 */
	public function sendToTopic(Topics $topics, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{

		$request = new Request(null, $options, $notification, $data, $topics);
		try {
			$response = $this->client->post($this->url, $request->build());
		}
		catch (ClientException $e) {
			$response = $e->getResponse();
		}


		return new TopicResponse($response, $topics);
	}


	/**
	 * get the url
	 *
	 * @return string
	 */
	protected function getUrl()
	{
		return $this->config[ 'server_send_url' ];
	}
}