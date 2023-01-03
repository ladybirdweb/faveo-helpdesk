<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Date_format extends BaseModel
{
    public $timestamps = false;

    protected $table = 'date_format';

    protected $fillable = ['id', 'format'];
}
