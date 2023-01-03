<?php

namespace App\Model\Common;

use App\BaseModel;

class TemplateSet extends BaseModel
{
    protected $table = 'template_sets';

    protected $fillable = ['name', 'active'];
}
