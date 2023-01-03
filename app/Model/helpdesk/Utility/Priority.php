<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Priority extends BaseModel
{
    public $timestamps = false;

    protected $table = 'ticket_priority';

    protected $fillable = [
        'id', 'name',
    ];
}
