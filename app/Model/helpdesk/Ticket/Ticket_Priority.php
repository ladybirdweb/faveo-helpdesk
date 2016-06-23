<?php

namespace App\Model\helpdesk\Ticket;

use App\BaseModel;

class Ticket_Priority extends BaseModel
{
    public $timestamps = false;
    protected $table = 'ticket_priority';
    protected $fillable = [
        'priority_id', 'priority', 'priority_desc', 'priority_color', 'priority_urgency', 'ispublic',
    ];
}
