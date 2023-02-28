<?php

namespace App\Model\kb;

use App\BaseModel;

class Faq extends BaseModel
{
    protected $table = 'faq';

    protected $fillable = ['id', 'faq'];
}
