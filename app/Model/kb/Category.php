<?php

namespace App\Model\kb;

use App\BaseModel;

class Category extends BaseModel
{
    protected $table = 'kb_category';

    protected $fillable = ['id', 'slug', 'name', 'description', 'status', 'parent', 'created_at', 'updated_at'];
}
