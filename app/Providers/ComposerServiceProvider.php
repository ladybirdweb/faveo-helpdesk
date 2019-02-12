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
        $service_desk = '';
        // if (isInstall()) {
        //     if (isPlugin()) {
        //         $service_desk = 'service::interface.agent.sidebar';
        //     }
        // }
        view()->composer(
            [
                'agent.layout.agent',
                'agent.helpdesk.dashboard.dashboard',
                'admin.layout.admin',
                'admin.helpdesk.setting',
                $service_desk,
            ], 'App\Http\ViewComposers\AgentLayout'
        );
        view()->composer(
            [
               'update.notification',
            ], 'App\Http\ViewComposers\UpdateNotification'
        );
        view()->composer(
            [
               'agent.layout.agent',
                'admin.layout.admin',
            ], 'App\Http\ViewComposers\AuthUser'
        );
        view()->composer(
            [
                'admin.layout.admin',
                'agent.layout.agent',
                'client.layout.client',
            ], 'App\Http\ViewComposers\UserLanguage'
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
