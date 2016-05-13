<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Form_type extends BaseModel
{
    protected $table = 'form_type';
    protected $fillable = [
        'id', 'type',
    ];
}
