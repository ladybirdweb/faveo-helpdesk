<?php namespace Bestmomo\Filemanager;
 
use Illuminate\Support\ServiceProvider;
 
class FilemanagerServiceProvider extends ServiceProvider{
 
 
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
 
    public function boot()
    {
        // Assets and config
        $this->publishes([
            __DIR__.'/../public' => public_path(),
            __DIR__.'/../config' => "config",
        ], 'public');
    }
 
    public function register() {}
 
}