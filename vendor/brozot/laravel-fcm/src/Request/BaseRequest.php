<?php namespace LaravelFCM\Request;

/**
 * Class BaseRequest
 *
 * @package LaravelFCM\Request
 */
abstract class BaseRequest {

	/**
	 * @internal
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	/**
	 * @internal
	 * @var array
	 */
	protected $config;

	/**
	 * BaseRequest constructor.
	 */
	public function __construct()
	{
		$this->config = app('config')->get('fcm.http', []);
	}

	/**
	 * Build the header for the request
	 *
	 * @return array
	 */
	protected function buildRequestHeader()
	{
		return [
			'Authorization' => "key=".$this->config['server_key'],
			'Content-Type' => "application/json",
			'project_id' => $this->config['sender_id']
		];
	}

	/**
	 * Build the body of the request
	 *
	 * @return mixed
	 */
	protected abstract function buildBody();

	/**
	 * Return the request in array form
	 *
	 * @return array
	 */
	public function build()
	{
		return [
			'headers' => $this->buildRequestHeader(),
			'json'    => $this->buildBody()
		];
	}
}