<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Faq extends BaseModel
{
    protected $table = 'faq';
    protected $fillable = ['id', 'faq'];
}
