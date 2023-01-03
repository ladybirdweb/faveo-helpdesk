<?php

namespace App\Model\kb;

use App\BaseModel;

class Country extends BaseModel
{
    public $table = 'country';

    protected $fillable = ['country_code', 'country_name'];
}
