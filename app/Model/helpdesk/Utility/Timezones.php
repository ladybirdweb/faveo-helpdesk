<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Timezones extends BaseModel
{
    public $timestamps = false;
    protected $table = 'timezone';
    protected $fillable = ['name', 'location'];
}
