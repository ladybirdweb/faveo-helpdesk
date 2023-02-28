<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Form_visibility extends BaseModel
{
    protected $table = 'form_visibility';

    protected $fillable = [
        'id', 'visibility',
    ];
}
