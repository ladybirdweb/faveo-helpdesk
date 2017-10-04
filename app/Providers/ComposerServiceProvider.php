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
        if (isInstall()) {
            if (isPlugin()) {
                $service_desk = 'service::interface.agent.sidebar';
            }
        }
        view()->composer(
            [
                'themes.default1.agent.layout.agent',
                'themes.default1.agent.helpdesk.dashboard.dashboard',
                'themes.default1.admin.layout.admin',
                'themes.default1.admin.helpdesk.setting',
                $service_desk,
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
        view()->composer(
            [
                'themes.default1.admin.layout.admin',
                'themes.default1.agent.layout.agent',
                'themes.default1.client.layout.client',
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
