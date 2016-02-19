<?php

namespace App\Model\helpdesk\Agent_panel;

use Illuminate\Database\Eloquent\Model;

class User_org extends Model
{
    /* define table name  */

    protected $table = 'user_assign_organization';

    /* define fillable fields */
    protected $fillable = ['id', 'org_id', 'user_id'];
}
