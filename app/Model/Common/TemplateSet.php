<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class TemplateSet extends Model
{
     protected $table = 'template_sets';
    protected $fillable = ['name', 'active'];
}
