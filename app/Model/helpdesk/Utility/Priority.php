<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    public $timestamps = false;
    protected $table = 'priority';
    protected $fillable = [
        'id', 'name',
    ];
}
