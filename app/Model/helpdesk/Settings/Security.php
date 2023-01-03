<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Security extends BaseModel
{
    /* Using auto_response table  */

    protected $table = 'settings_security';

    /* Set fillable fields in table */
    protected $fillable = [

        'id', 'lockout_message', 'backlist_offender', 'backlist_threshold', 'lockout_period', 'days_to_keep_logs',
    ];
}
