<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Template extends Model
{
    protected $table = 'templates';
    protected $fillable = ['name', 'message', 'type', 'subject'];
}
