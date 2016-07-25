<?php

namespace App\FaveoMailer;
use Illuminate\Support\ServiceProvider;

class ServiceProvider extends ServiceProvider{

    public function register() {
        parent::register('FaveoMailer');
    }

    public function boot() {

       
        /**
         * Views
         */
        
         $view_path = app_path().DIRECTORY_SEPARATOR.'FaveoMailer'.DIRECTORY_SEPARATOR.'Views';
         $this->loadViewsFrom($view_path, 'mailer');
        
        /**
         * Translation
         */
        $trans = app_path().DIRECTORY_SEPARATOR.'FaveoMailer'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($trans, 'service');
        
        
        
        parent::boot('FaveoMailer');

    }

}
