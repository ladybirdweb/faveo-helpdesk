<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class Time_format extends Model
{
    public $timestamps = false;
    protected $table = 'time_format';
    protected $fillable = ['id', 'format'];
}
