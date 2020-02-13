<?php

namespace App\Model\helpdesk\Agent_panel;

use App\BaseModel;

class User_org extends BaseModel
{
    /* define table name  */

    protected $table = 'user_assign_organization';

    /* define fillable fields */
    protected $fillable = ['id', 'org_id', 'user_id'];

    public function setOrgIdAttribute($value)
    {
        if ($value == '') {
            $this->attributes['org_id'] = null;
        } else {
            $this->attributes['org_id'] = $value;
        }
    }
}
