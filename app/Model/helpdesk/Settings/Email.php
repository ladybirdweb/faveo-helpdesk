<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Email extends BaseModel
{
    /* Using Email table  */

    protected $table = 'settings_email';

    /* Set fillable fields in table */
    protected $fillable = [
        'id', 'template', 'sys_email', 'alert_email', 'admin_email', 'mta', 'email_fetching', 'strip',
        'separator', 'all_emails', 'email_collaborator', 'attachment',
    ];
}
