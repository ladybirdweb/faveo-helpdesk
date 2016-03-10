<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /* Using System Table */

    protected $table = 'settings_system';
    protected $fillable = [

        'id', 'status', 'url', 'name', 'department', 'page_size', 'log_level', 'purge_log', 'name_format',
        'time_farmat', 'date_format', 'date_time_format', 'day_date_time', 'time_zone', 'content', 'api_key', 'api_enable', 'api_key_mandatory'
    ];
}
