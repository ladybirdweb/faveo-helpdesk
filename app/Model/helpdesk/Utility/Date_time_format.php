<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Date_time_format extends BaseModel
{
    public $timestamps = false;

    protected $table = 'date_time_format';

    protected $fillable = ['id', 'format'];
}
