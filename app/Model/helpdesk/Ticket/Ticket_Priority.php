<?php

namespace App\Model\helpdesk\Ticket;

use App\BaseModel;

class Ticket_Priority extends BaseModel
{
    protected $primaryKey = 'priority_id';

    public $timestamps = false;

    protected $table = 'ticket_priority';

    protected $fillable = [
        'priority_id', 'priority', 'status', 'user_priority_status', 'priority_desc', 'priority_color', 'priority_urgency', 'ispublic', 'created_at', 'updated_at',
    ];
}
