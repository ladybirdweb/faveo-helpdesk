<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Plugin extends BaseModel
{
    protected $table = 'plugins';
    protected $fillable = ['name', 'path', 'status'];
}
