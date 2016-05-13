<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Footer extends BaseModel
{
    protected $table = 'footer';
    protected $fillable = ['title', 'footer'];
}
