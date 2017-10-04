<?php

namespace App\Model\helpdesk\Workflow;

use App\BaseModel;

class WorkflowName extends BaseModel
{
    protected $table = 'workflow_name';
    protected $fillable = ['id', 'name', 'status', 'order', 'target', 'internal_note', 'updated_at', 'created_at'];

    public function rule()
    {
        return $this->hasMany('App\Model\helpdesk\Workflow\WorkflowRules', 'workflow_id');
    }

    public function action()
    {
        return $this->hasMany('App\Model\helpdesk\Workflow\WorkflowAction', 'workflow_id');
    }

    public function targets()
    {
        return $this->belongsTo('App\Model\helpdesk\Ticket\Ticket_source', 'target');
    }
}
