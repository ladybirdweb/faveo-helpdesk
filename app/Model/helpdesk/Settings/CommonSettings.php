<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class CommonSettings extends BaseModel {

    protected $table = 'common_settings';
    protected $fillable = [
        'optional', 'key', 'value', 'created_at', 'updated_at',
    ];

}
