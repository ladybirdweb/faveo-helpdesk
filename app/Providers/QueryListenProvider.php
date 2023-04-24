<?php

namespace App\Providers;

use Clockwork\Support\Laravel\ClockworkMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class QueryListenProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            \Clockwork::info($query->sql, [$query->time]);
        });

        $this->app['router']->aliasMiddleware('clockwork', ClockworkMiddleware::class);
    }
}
