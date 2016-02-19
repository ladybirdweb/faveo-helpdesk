<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class Ticket_thread extends Model
{
    protected $table = 'ticket_thread';
    protected $fillable = [
        'id', 'ticket_id', 'ticket_subject', 'ticket_message', 'time', 'poster', 'created_at', 'updated_at',
    ];
}
