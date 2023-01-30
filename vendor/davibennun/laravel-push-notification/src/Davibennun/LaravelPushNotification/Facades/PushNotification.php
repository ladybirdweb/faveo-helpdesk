<?php namespace Davibennun\LaravelPushNotification\Facades;

use Illuminate\Support\Facades\Facade;

class PushNotification extends Facade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'pushNotification'; }

}