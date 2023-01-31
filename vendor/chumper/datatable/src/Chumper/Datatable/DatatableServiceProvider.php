<?php namespace Chumper\Datatable;

use Illuminate\Support\ServiceProvider;
use View;

class DatatableServiceProvider extends ServiceProvider {

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
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('chumper.datatable.php'),
            __DIR__.'/../../views' => base_path('resources/views/vendor/chumper.datatable'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../../views', 'chumper.datatable');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'chumper.datatable');

        $this->app->singleton('datatable', function($app)
        {
            return new Datatable;
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('datatable');
    }

}