<?php

namespace App\Model\Api;

use App\BaseModel;

class ApiSetting extends BaseModel
{
    protected $table = 'api_settings';

    protected $fillable = ['key', 'value'];
}
