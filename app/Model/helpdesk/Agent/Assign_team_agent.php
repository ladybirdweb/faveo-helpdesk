<?php

namespace App\Model\helpdesk\Agent;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Assign_team_agent extends BaseModel
{
    protected $table = 'team_assign_agent';
    protected $fillable = ['id', 'team_id', 'agent_id'];
}
