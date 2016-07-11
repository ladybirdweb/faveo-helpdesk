<?php namespace LaravelFCM;

use Illuminate\Support\ServiceProvider;
use LaravelFCM\Sender\FCMSender;
use LaravelFCM\Sender\FCMGroup;

class FCMServiceProvider extends ServiceProvider {

	public function boot()
	{
		if (str_contains($this->app->version(), 'Lumen')) {
			$this->app->configure('fcm');
		}
		else {
			$this->publishes([
				__DIR__."/../config/fcm.php" => config_path('fcm.php')
			]);
		}
	}

	public function register()
	{
		$this->app->bind('fcm.group', function($app) {
			return new FCMGroup();
		});

		$this->app->bind('fcm.sender', function($app) {
			return new FCMSender();
		});
		
		$this->registerClient();
	}

	public function registerClient()
	{
		$this->app->singleton('fcm.client', function($app) {
			return (new FCMManager($app))->driver();
		});
	}

	protected function provide()
	{
		return [ 'fcm', 'fcm.client' ];
	}
}