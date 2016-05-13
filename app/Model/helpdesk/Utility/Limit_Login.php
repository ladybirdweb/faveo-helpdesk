<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Limit_Login extends BaseModel
{
    protected $table = 'limit_login';
    protected $fillable = ['email', 'ip_address', 'duration', 'attempt_time', 'created_at', 'updated_at'];
}
