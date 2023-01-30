<?php

use Illuminate\Foundation\Testing\TestCase;

abstract class FCMTestCase extends TestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        $app->register(LaravelFCM\FCMServiceProvider::class);

        $app['config']['fcm.driver'] = 'http';
        $app['config']['fcm.http.timeout'] = 20;
        $app['config']['fcm.http.server_send_url'] = 'http://test.test';
        $app['config']['fcm.http.server_key'] = 'key=myKey';
        $app['config']['fcm.http.sender_id'] = 'SENDER_ID';

        return $app;
    }
}
