<?php

namespace App\Plugins\Podio;

class ServiceProvider extends \App\Plugins\ServiceProvider
{
    public function register()
    {
        parent::register('Podio');
    }

    public function boot()
    {
        /*
         * Views
         */

        $view_path = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Podio'.DIRECTORY_SEPARATOR.'views';
        $this->loadViewsFrom($view_path, 'Podio');

        /*
         * Translation
         */
        $trans = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Podio'.DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($trans, 'Podio');
        parent::boot('Podio');
    }
}
