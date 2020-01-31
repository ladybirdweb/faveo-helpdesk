<?php

namespace Madnest\Madzipper\Facades;

use Illuminate\Support\Facades\Facade;

class Madzipper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'madzipper';
    }
}
