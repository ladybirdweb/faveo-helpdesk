<?php

namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Ticket_source extends BaseModel
{
    public $timestamps = false;
    protected $table = 'ticket_source';
    protected $fillable = [
        'name', 'value',
    ];
}
