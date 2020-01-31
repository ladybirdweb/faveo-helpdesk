<?php

namespace Bugsnag\BugsnagLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Bugsnag extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bugsnag';
    }
}
