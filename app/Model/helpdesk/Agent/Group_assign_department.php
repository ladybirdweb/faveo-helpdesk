<?php

namespace App\Model\helpdesk\Agent;

use App\BaseModel;

class Group_assign_department extends BaseModel
{
    protected $table = 'group_assign_department';

    protected $fillable = ['group_id', 'department_id'];
}
