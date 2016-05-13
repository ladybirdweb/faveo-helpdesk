<?php

namespace App\Model\helpdesk\Agent_panel;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class User_org_head extends BaseModel
{
    /* define table name  */

    protected $table = 'user_org_head';

    /* define fillable fields */
    protected $fillable = ['id', 'org_id', 'user_id', 'updated_at', 'created_at'];
}
