<?php

namespace Madnest\Madzipper;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MadzipperServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    { }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('madzipper', function ($app) {
            $return = $app->make('Madnest\Madzipper\Madzipper');

            return $return;
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Madzipper', 'Madnest\Madzipper\Facades\Madzipper');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['madzipper'];
    }
}
