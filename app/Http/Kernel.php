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
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //\App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\LanguageMiddleware::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'        => \App\Http\Middleware\Authenticate::class,
        'auth.basic'  => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'       => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'roles'       => \App\Http\Middleware\CheckRole::class,
        'role.agent'  => \App\Http\Middleware\CheckRoleAgent::class,
        'role.user'   => \App\Http\Middleware\CheckRoleUser::class,
        'api'         => \App\Http\Middleware\ApiKey::class,
        'jwt.auth'    => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
    ];
}
