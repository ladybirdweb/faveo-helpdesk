<?php

namespace App\Model\helpdesk\Ticket;

use App\BaseModel;

class Ticket_Status extends BaseModel
{
    protected $table = 'ticket_status';
    protected $fillable = [
        'id', 'name', 'state', 'message', 'mode', 'flag', 'sort', 'properties', 'icon_class', 'send_email',
    ];

    public function type()
    {
        return $this->belongsTo('App\Model\helpdesk\Ticket\TicketStatusType', 'purpose_of_status');
    }

    public function getSendEmailAttribute($value)
    {
        if ($value) {
            $value = json_decode($value, true);
        }

        return $value;
    }
}
