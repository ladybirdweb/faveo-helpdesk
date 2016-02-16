<?php

namespace App\Model\helpdesk\Agent_panel;

use Illuminate\Database\Eloquent\Model;

class User_org_head extends Model {
    /* define table name  */

    protected $table = 'user_org_head';

    /* define fillable fields */
    protected $fillable = ['id', 'org_id', 'user_id', 'updated_at', 'created_at'];

}
