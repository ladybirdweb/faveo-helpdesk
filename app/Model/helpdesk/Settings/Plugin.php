<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Plugin extends BaseModel
{
    protected $table = 'plugins';

    protected $fillable = ['name', 'path', 'status'];
}
