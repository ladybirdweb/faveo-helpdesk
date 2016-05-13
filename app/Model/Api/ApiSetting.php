<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class ApiSetting extends BaseModel
{
    protected $table = 'api_settings';
    protected $fillable  = ['key','value'];
}
