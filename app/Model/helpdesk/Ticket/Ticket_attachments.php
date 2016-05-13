<?php

namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Ticket_attachments extends BaseModel
{
    protected $table = 'ticket_attachment';
    protected $fillable = [
                            'id', 'thread_id', 'name', 'size', 'type', 'file', 'data', 'poster', 'updated_at', 'created_at',
                            ];
}
