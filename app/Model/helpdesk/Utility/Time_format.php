<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Time_format extends BaseModel
{
    public $timestamps = false;

    protected $table = 'time_format';

    protected $fillable = ['id', 'format'];
}
