<?php

namespace App\Model\helpdesk\Filters;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['name', 'description'];
}
