<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Side1 extends BaseModel
{
    protected $table = 'side1';
    protected $fillable = ['title', 'content'];
}
