<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * Kernel.
 */
class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\LanguageMiddleware::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'roles' => \App\Http\Middleware\CheckRole::class,
        'role.agent' => \App\Http\Middleware\CheckRoleAgent::class,
        'role.user' => \App\Http\Middleware\CheckRoleUser::class,
        'api' => \App\Http\Middleware\ApiKey::class,
        'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
        'jwt.authOveride' => \App\Http\Middleware\JwtAuthenticate::class,
        'update' => \App\Http\Middleware\CheckUpdate::class,
        'board' => \App\Http\Middleware\CheckBoard::class,
        'install' => \App\Http\Middleware\Install::class,
        'redirect' => \App\Http\Middleware\Redirect::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'installer' => \App\Http\Middleware\IsInstalled::class,
        'force.option' => \App\Http\Middleware\TicketViewURL::class,
    ];
}
