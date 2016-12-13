<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            [
                'themes.default1.agent.layout.agent',
                'themes.default1.agent.helpdesk.dashboard.dashboard'
            ], 'App\Http\ViewComposers\AgentLayout'
        );
        view()->composer(
            [
               'themes.default1.update.notification',
            ], 'App\Http\ViewComposers\UpdateNotification'
        );
        view()->composer(
            [
               'themes.default1.agent.layout.agent',
                'themes.default1.admin.layout.admin',
            ], 'App\Http\ViewComposers\AuthUser'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
