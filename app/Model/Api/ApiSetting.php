<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;

class ApiSetting extends Model
{
    protected $table = 'api_settings';
    protected $fillable  = ['key','value'];
}
