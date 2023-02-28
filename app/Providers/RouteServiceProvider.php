<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
            $this->mapInstallerRoutes();
            $this->mapUpdateRoutes();
            //
        });
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
        Route::middleware('web')->group(function ($router) {
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
        Route::middleware('api')->prefix('api')->group(function ($router) {
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
        Route::middleware('web', 'installer')->group(function ($router) {
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
        Route::middleware('web', 'redirect', 'install')->prefix('app/update')->group(function ($router) {
            require base_path('routes/update.php');
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
