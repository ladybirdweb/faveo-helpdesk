<?php

namespace App\FaveoStorage;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $view_path = app_path().DIRECTORY_SEPARATOR.'FaveoStorage'.DIRECTORY_SEPARATOR.'views';
        $this->loadViewsFrom($view_path, 'storage');

        $lang_path = app_path().DIRECTORY_SEPARATOR.'FaveoStorage'.DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($lang_path, 'storage');

        if (isInstall()) {
            $controller = new Controllers\SettingsController();
            $controller->activate();
        }

        if (class_exists('Breadcrumbs')) {
            require __DIR__.'/breadcrumbs.php';
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Add routes
        if (isInstall()) {
            $routes = app_path('/FaveoStorage/routes.php');
            if (file_exists($routes)) {
                require $routes;
            }
        }
    }
}
