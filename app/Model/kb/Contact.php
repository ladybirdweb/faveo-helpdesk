<?php

namespace App\Model\kb;

use App\BaseModel;

class Contact extends BaseModel
{
    protected $table = 'contact';

    protected $fillable = ['name', 'subject', 'email', 'message'];
}
