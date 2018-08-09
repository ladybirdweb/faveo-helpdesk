<?php

namespace Thomaswelton\LaravelGravatar;

use Illuminate\Support\ServiceProvider;

class LaravelGravatarServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/gravatar.php');
        $this->publishes([$source => config_path('gravatar.php')]);
        $this->mergeConfigFrom($source, 'gravatar');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('gravatar', function ($app) {
            return new Gravatar($this->app['config']);
        });
    }
}
