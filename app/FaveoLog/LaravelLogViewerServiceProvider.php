<?php

namespace App\FaveoLog;

use Illuminate\Support\ServiceProvider;

class LaravelLogViewerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (method_exists($this, 'package')) {
            $this->package('rap2hpoutre/laravel-log-viewer', 'laravel-log-viewer', __DIR__.'/../../');
        }

        $view_path = app_path().DIRECTORY_SEPARATOR.'FaveoLog'.DIRECTORY_SEPARATOR.'views';
        $this->loadViewsFrom($view_path, 'log');

        $lang_path = app_path().DIRECTORY_SEPARATOR.'FaveoLog'.DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($lang_path, 'log');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Add routes
        $routes = app_path('/FaveoLog/routes.php');
        if (file_exists($routes)) {
            require $routes;
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
