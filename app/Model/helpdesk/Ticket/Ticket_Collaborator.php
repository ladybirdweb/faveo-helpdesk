<?php

namespace App\Model\helpdesk\Ticket;

use App\BaseModel;

class Ticket_Collaborator extends BaseModel
{
    protected $table = 'ticket_collaborator';

    protected $fillable = [
        'id', 'isactive', 'ticket_id', 'user_id', 'role', 'updated_at', 'created_at',
    ];
}
