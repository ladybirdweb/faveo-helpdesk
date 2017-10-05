<?php

namespace App\Providers;

use App\Model\Update\BarNotification;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Queue;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Illuminate\Contracts\Auth\Registrar');
        require_once __DIR__.'/../Http/helpers.php';
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
        if (isInstall()) {
            $this->plugin();
        }
    }

    public function boot()
    {
        Queue::failing(function (JobFailed $event) {
            loging('Failed Job - '.$event->connectionName, json_encode([$event->job->payload(), 'error' => $event->exception->getMessage()]));
        });
        Route::singularResourceParameters(false);
        $this->composer();
    }

    public function composer()
    {
        \View::composer('themes.default1.update.notification', function () {
            $notification = new BarNotification();
            $not = [
                'notification' => $notification->where('value', '!=', '')->get(),
            ];
            view()->share($not);
        });
    }

    public function plugin()
    {
        if (isPlugin('Ldap') && $this->isPluginDir('Ldap')) {
            $this->app->register(\App\Plugins\Ldap\ServiceProvider::class);
        }
        if (isPlugin('Chat') && $this->isPluginDir('Chat')) {
            $this->app->register(\App\Plugins\Chat\ServiceProvider::class);
        }
        if (isPlugin('Envato') && $this->isPluginDir('Envato')) {
            $this->app->register(\App\Plugins\Envato\ServiceProvider::class);
        }
        if (isPlugin('Htrunk') && $this->isPluginDir('Htrunk')) {
            $this->app->register(\App\Plugins\Htrunk\ServiceProvider::class);
        }
        if (isPlugin('HtrunkDocs') && $this->isPluginDir('HtrunkDocs')) {
            $this->app->register(\App\Plugins\HtrunkDocs\ServiceProvider::class);
        }
        if (isPlugin('Licenses') && $this->isPluginDir('Licenses')) {
            $this->app->register(\App\Plugins\Licenses\ServiceProvider::class);
        }
        if (isPlugin('Migration') && $this->isPluginDir('Migration')) {
            $this->app->register(\App\Plugins\Migration\ServiceProvider::class);
        }
        if (isPlugin('Reseller') && $this->isPluginDir('Reseller')) {
            $this->app->register(\App\Plugins\Reseller\ServiceProvider::class);
        }
        if (isPlugin('SMS') && $this->isPluginDir('SMS')) {
            $this->app->register(\App\Plugins\SMS\ServiceProvider::class);
        }
        if (isPlugin('ServiceDesk') && $this->isPluginDir('ServiceDesk')) {
            $this->app->register(\App\Plugins\ServiceDesk\ServiceProvider::class);
        }
        if (isPlugin('Social') && $this->isPluginDir('Social')) {
            $this->app->register(\App\Plugins\Social\ServiceProvider::class);
        }
        if (isPlugin('Telephony') && $this->isPluginDir('Telephony')) {
            $this->app->register(\App\Plugins\Telephony\ServiceProvider::class);
        }
        if (isPlugin('Zapier') && $this->isPluginDir('Zapier')) {
            $this->app->register(\App\Plugins\Zapier\ServiceProvider::class);
        }
        if ($this->isModuleDir('Location')) {
            $this->app->register(\App\Location\LocationServiceProvider::class);
        }
    }

    public function isPluginDir($name)
    {
        $check = false;
        if (is_dir(app_path('Plugins'.DIRECTORY_SEPARATOR.$name))) {
            $check = true;
        }

        return $check;
    }

    public function isModuleDir($name)
    {
        $check = false;
        if (is_dir(app_path($name))) {
            $check = true;
        }

        return $check;
    }
}
