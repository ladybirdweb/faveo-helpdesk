<?php

namespace App\Plugins\Zapier;

class ServiceProvider extends \App\Plugins\ServiceProvider
{
    public function register()
    {
        parent::register('Zapier');
    }

    public function boot()
    {
        /*
         * Views
         */
        $view_path = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Zapier'.DIRECTORY_SEPARATOR.'views';
        $this->loadViewsFrom($view_path, 'zapier');

//        if (class_exists('Breadcrumbs')) {
//            require __DIR__ . '/breadcrumbs.php';
//        }

        /*
         * Translation
         */
        $trans = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Zapier'.DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($trans, 'zapier');

        $controller = new Controllers\Core\SettingsController();
        $controller->activate();

        parent::boot('Zapier');
    }
}
