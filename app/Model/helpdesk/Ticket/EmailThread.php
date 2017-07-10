<?php

namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class EmailThread extends Model
{
    protected $table = 'email_threads';
    
    protected $fillable = ['ticket_id','thread_id','message_id','uid','reference_id'];
    
    public function ticket(){
        $related = 'App\Model\helpdesk\Ticket\Tickets';
        $foreignKey = 'ticket_id';
        return $this->belongsTo($related, $foreignKey);
    }
    
    public function thread(){
        $related = 'App\Model\helpdesk\Ticket\Ticket_Thread';
        $foreignKey = 'thread_id';
        return $this->belongsTo($related, $foreignKey);
    }
}
