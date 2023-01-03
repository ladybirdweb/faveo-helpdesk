<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapInstallerRoutes();
        $this->mapUpdateRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }

    /**
     * Define the "installer" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapInstallerRoutes()
    {
        Route::group([
            'middleware' => ['web', 'installer'],
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/installer.php');
        });
    }

    /**
     * Define the "update" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapUpdateRoutes()
    {
        Route::group([
            'middleware' => ['web', 'redirect', 'install'],
            'namespace' => $this->namespace,
            'prefix' => 'app/update',
        ], function ($router) {
            require base_path('routes/update.php');
        });
    }
}
