<?php

namespace App\Model\helpdesk\Workflow;

use App\BaseModel;

class WorkflowName extends BaseModel
{
    protected $table = 'workflow_name';

    protected $fillable = ['id', 'name', 'status', 'order', 'target', 'internal_note', 'updated_at', 'created_at'];
}
