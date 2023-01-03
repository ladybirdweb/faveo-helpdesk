<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class CountryCode extends BaseModel
{
    protected $table = 'country_code';

    protected $fillable = ['id', 'name', 'iso', 'nicename', 'iso3', 'numcode', 'phonecode', 'updated_at', 'created_at'];
}
