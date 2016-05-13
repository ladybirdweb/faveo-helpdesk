<?php

namespace App\Model\helpdesk\Agent;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Teams extends BaseModel
{
    protected $table = 'teams';
    protected $fillable = [
        'name', 'status', 'team_lead', 'assign_alert', 'admin_notes',
    ];
}
