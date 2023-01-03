<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Otp extends BaseModel
{
    protected $table = 'user_verification';

    protected $fillable = ['id', 'user_id', 'otp', 'temp_mobile', 'updated_at', 'created_at'];
}
