<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class CommonSettings extends BaseModel
{
    protected $table = 'common_settings';
    protected $fillable = [
        'status', 'option_name', 'option_value', 'optional_field', 'created_at', 'updated_at',
    ];
}
