<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class Timezones extends Model
{
    public $timestamps = false;
    protected $table = 'timezone';
    protected $fillable = ['name', 'location'];
}
