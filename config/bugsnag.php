<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| API Key
	|--------------------------------------------------------------------------
	|
	| You can find your API key on your Bugsnag dashboard.
	|
	| This api key points the Bugsnag notifier to the project in your account
	| which should receive your application's uncaught exceptions.
	|
	*/
	'api_key' => '280264db78f78f46e37169b2b65bed2d',

	/*
	|--------------------------------------------------------------------------
	| Notify Release Stages
	|--------------------------------------------------------------------------
	|
	| Set which release stages should send notifications to Bugsnag.
	|
	| Example: array('development', 'production')
	|
	*/
	'notify_release_stages' => env('BUGSNAG_NOTIFY_RELEASE_STAGES', null),

	/*
	|--------------------------------------------------------------------------
	| Endpoint
	|--------------------------------------------------------------------------
	|
	| Set what server the Bugsnag notifier should send errors to. By default
	| this is set to 'https://notify.bugsnag.com', but for Bugsnag Enterprise
	| this should be the URL to your Bugsnag instance.
	|
	*/
	'endpoint' => 'https://notify.bugsnag.com',

	/*
	|--------------------------------------------------------------------------
	| Filters
	|--------------------------------------------------------------------------
	|
	| Use this if you want to ensure you don't send sensitive data such as
	| passwords, and credit card numbers to our servers. Any keys which
	| contain these strings will be filtered.
	|
	*/
	'filters' => env('BUGSNAG_FILTERS', array('password')),

	/*
	|--------------------------------------------------------------------------
	| Proxy
	|--------------------------------------------------------------------------
	|
	| If your server is behind a proxy server, you can configure this as well.
	| Other than the host, none of these settings are mandatory.
	|
	| Note: Proxy configuration is only possible if the PHP cURL extension
	| is installed.
	|
	| Example:
	|
	|     'proxy' => array(
	|         'host'     => 'bugsnag.com',
	|         'port'     => 42,
	|         'user'     => 'username',
	|         'password' => 'password123'
	|     )
	|
	*/
	'proxy' => env('BUGSNAG_PROXY', null)

);
