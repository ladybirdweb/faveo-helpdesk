<?php namespace Bugsnag\BugsnagLaravel;

use Illuminate\Support\Facades\Facade;

class BugsnagFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bugsnag';
    }
}
