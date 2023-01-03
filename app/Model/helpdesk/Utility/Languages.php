<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Languages extends BaseModel
{
    public $timestamps = false;

    protected $table = 'languages';

    protected $fillable = ['name', 'locale'];
}
