<?php

namespace App\FaveoJob;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function boot() {
        $this->publishes([
            'app/FaveoJob/Config/config.php' => config_path('FaveoJob/config.php'),
        ]);
    }

    public function register() {

        $this->publishes([
            'app/FaveoJob/config.php' => config_path('FaveoJob/config.php'),
        ]);

        // Add routes
        $routes = app_path() . '/FaveoJob/routes.php';
        if (file_exists($routes)) {
            require $routes;
        }
    }

    

}
