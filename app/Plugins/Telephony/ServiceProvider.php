<?php

namespace App\Plugins\Telephony;

class ServiceProvider extends \App\Plugins\ServiceProvider
{
    public function register()
    {
        parent::register('Telephony');
    }

    public function boot()
    {
        /*
         * Views
         */
        $view_path = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Telephony'.DIRECTORY_SEPARATOR.'views';
        $this->loadViewsFrom($view_path, 'telephone');

//        if (class_exists('Breadcrumbs')) {
//            require __DIR__ . '/breadcrumbs.php';
//        }

        /*
         * Translation
         */
        $trans = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Telephony'.DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($trans, 'telephone');

        $controller = new Controllers\Core\SettingsController();
        $controller->activate();

        parent::boot('Telephony');
    }
}
