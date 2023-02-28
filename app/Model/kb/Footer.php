<?php

namespace App\Model\kb;

use App\BaseModel;

class Footer extends BaseModel
{
    protected $table = 'footer';

    protected $fillable = ['title', 'footer'];
}
