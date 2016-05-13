<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Email extends Model
{
    /* Using Email table  */

    protected $table = 'settings_email';
    /* Set fillable fields in table */
    protected $fillable = [
        'id', 'template', 'sys_email', 'alert_email', 'admin_email', 'mta', 'email_fetching', 'strip',
        'separator', 'all_emails', 'email_collaborator', 'attachment',
    ];
}
