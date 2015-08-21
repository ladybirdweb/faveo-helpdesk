<?php namespace Thomaswelton\LaravelGravatar;

use Illuminate\Support\ServiceProvider;

class LaravelGravatarServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../../../config/gravatar.php');
        $this->publishes([$source => config_path('gravatar.php')]);
        $this->mergeConfigFrom($source, 'gravatar');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['gravatar'] = $this->app->share(function($app)
        {
            return new Gravatar($this->app['config']);
        });
    }
}
