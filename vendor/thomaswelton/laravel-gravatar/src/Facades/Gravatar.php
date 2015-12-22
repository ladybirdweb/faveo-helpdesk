<?php

namespace Thomaswelton\LaravelGravatar\Facades;

use Illuminate\Support\Facades\Facade;

class Gravatar extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gravatar';
    }
}
