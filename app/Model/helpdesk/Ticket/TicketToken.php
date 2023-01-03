<?php

namespace App\Model\helpdesk\Ticket;

use App\BaseModel;

class TicketToken extends BaseModel
{
    protected $table = 'ticket_token';

    protected $fillable = [
        'id', 'ticket_id', 'token', 'created_at', 'updated_at',
    ];
}
