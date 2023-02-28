<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Logs extends BaseModel
{
    public $timestamps = false;

    protected $table = 'logs';

    protected $fillable = ['id', 'level'];
}
