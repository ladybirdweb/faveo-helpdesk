<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class TemplateSet extends Model
{
     protected $table = 'template_sets';
    protected $fillable = ['name', 'active'];
}
