<?php

namespace App\Model\helpdesk\Agent;

use App\BaseModel;

class Department extends BaseModel
{
    protected $table = 'department';
    protected $fillable = [
        'name', 'type', 'sla', 'manager', 'ticket_assignment', 'outgoing_email',
        'template_set', 'auto_ticket_response', 'auto_message_response',
        'auto_response_email', 'recipient', 'group_access', 'department_sign',
    ];
    
    public function assignAgent(){
        $related = "App\Model\helpdesk\Agent\DepartmentAssignAgents";
        return $this->hasMany($related, 'department_id');
    }
    
    public function ticket(){
        return $this->hasMany('App\Model\helpdesk\Ticket\Tickets','dept_id');
    }
    
    public function helptopic(){
        return $this->hasMany('App\Model\helpdesk\Manage\Help_topic','department');
    }
    
    public function delete() {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->assignAgent()->delete();
        $this->ticket()->update(['dept_id'=>null]);
        parent::delete();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
