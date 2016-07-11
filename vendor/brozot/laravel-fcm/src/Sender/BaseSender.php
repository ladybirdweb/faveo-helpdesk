<?php namespace LaravelFCM\Sender;

/**
 * Class BaseSender
 *
 * @package LaravelFCM\Sender
 */
abstract class BaseSender {

	/**
	 * Guzzle Client
	 * @var \Illuminate\Foundation\Application|mixed
	 */
	protected $client;

	/**
	 * configuration
	 * @var array
	 */
	protected $config;

	/**
	 * url
	 * @var mixed
	 */
	protected $url;

	/**
	 * BaseSender constructor.
	 */
	public function __construct()
	{
		$this->client = app('fcm.client');
		$this->config = app('config')->get('fcm.http', []);

		$this->url = $this->getUrl();
	}

	/**
	 * get the url
	 *
	 * @return string
	 */
	protected abstract function getUrl();
}