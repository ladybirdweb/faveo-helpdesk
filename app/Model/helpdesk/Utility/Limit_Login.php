<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Limit_Login extends BaseModel
{
    protected $table = 'login_attempts';

    protected $fillable = ['User', 'IP', 'Attempts', 'LastLogin', 'created_at', 'updated_at'];
}
