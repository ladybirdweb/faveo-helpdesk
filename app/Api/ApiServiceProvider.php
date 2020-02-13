<?php

namespace App\Api;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Add routes
        // if (isInstall()) {
        $routes = app_path('/Api/routes.php');
        if (file_exists($routes)) {
            require $routes;
        }
        // }
    }
}
