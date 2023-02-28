<?php

namespace App\Model\kb;

use App\BaseModel;

class Options extends BaseModel
{
    protected $table = 'options';

    protected $fillable = ['option_name', 'option_value', 'created_at', 'updated_at'];
}
