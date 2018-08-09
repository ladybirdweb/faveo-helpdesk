<?php

namespace App\Model\helpdesk\Agent;

use App\BaseModel;

class Teams extends BaseModel
{
    protected $table = 'teams';
    protected $fillable = [
        'name', 'status', 'team_lead', 'assign_alert', 'admin_notes',
    ];

    public function ticket()
    {
        return $this->hasMany('App\Model\helpdesk\Ticket\Tickets', 'team_id');
    }

    public function delete()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->ticket()->update(['team_id'=>null]);
        parent::delete();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
