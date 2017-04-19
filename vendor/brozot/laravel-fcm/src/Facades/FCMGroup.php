<?php

namespace LaravelFCM\Facades;

use Illuminate\Support\Facades\Facade;

class FCMGroup extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fcm.group';
    }
}
