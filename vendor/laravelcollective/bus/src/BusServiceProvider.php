<?php

namespace Collective\Bus;

use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Collective\Bus\Dispatcher', function ($app) {
            return new Dispatcher($app, function () use ($app) {
                return $app['Illuminate\Contracts\Queue\Queue'];
            });
        });

        $this->app->alias(
            'Collective\Bus\Dispatcher', 'Illuminate\Contracts\Bus\Dispatcher'
        );

        $this->app->alias(
            'Collective\Bus\Dispatcher', 'Illuminate\Contracts\Bus\QueueingDispatcher'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Collective\Bus\Dispatcher',
            'Illuminate\Contracts\Bus\Dispatcher',
            'Illuminate\Contracts\Bus\QueueingDispatcher',
        ];
    }
}
