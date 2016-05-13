<?php

namespace App\Model\helpdesk\Manage;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Sla_plan extends BaseModel
{
    protected $table = 'sla_plan';
    protected $fillable = [
        'name', 'grace_period', 'admin_note', 'status', 'transient', 'ticket_overdue',
    ];
}
