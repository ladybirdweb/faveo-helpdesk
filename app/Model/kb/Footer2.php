<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Footer2 extends BaseModel
{
    protected $table = 'footer2';
    protected $fillable = ['title', 'footer'];
}
