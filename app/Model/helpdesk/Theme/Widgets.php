<?php

namespace App\Model\helpdesk\Theme;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Widgets extends BaseModel
{
    protected $table = 'widgets';
    protected $fillable = ['name', 'value', 'created_at', 'updated_at'];
}
