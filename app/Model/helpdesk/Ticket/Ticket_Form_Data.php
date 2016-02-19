<?php

namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_Form_Data extends Model
{
    protected $table = 'ticket_form_data';
    protected $fillable = ['id', 'ticket_id', 'title', 'content', 'created_at', 'updated_at'];
}
