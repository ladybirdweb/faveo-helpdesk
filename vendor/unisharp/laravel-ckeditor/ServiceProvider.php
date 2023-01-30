<?php

namespace Unisharp\Ckeditor;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/ckeditor.js' => public_path('vendor/unisharp/laravel-ckeditor/ckeditor.js'),
                __DIR__ . '/config.js' => public_path('vendor/unisharp/laravel-ckeditor/config.js'),
                __DIR__ . '/styles.js' => public_path('vendor/unisharp/laravel-ckeditor/styles.js'),
                __DIR__ . '/contents.css' => public_path('vendor/unisharp/laravel-ckeditor/contents.css'),
                __DIR__ . '/adapters' => public_path('vendor/unisharp/laravel-ckeditor/adapters'),
                __DIR__ . '/lang' => public_path('vendor/unisharp/laravel-ckeditor/lang'),
                __DIR__ . '/skins' => public_path('vendor/unisharp/laravel-ckeditor/skins'),
                __DIR__ . '/plugins' => public_path('vendor/unisharp/laravel-ckeditor/plugins'),
            ],
            'ckeditor'
        ); 
    }

    public function register()
    {

    }
}
