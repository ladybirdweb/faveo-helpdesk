<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    protected $table = 'country_code';
    protected $fillable = ['id', 'name', 'iso', 'nicename', 'iso3', 'numcode', 'phonecode', 'updated_at', 'created_at'];
}