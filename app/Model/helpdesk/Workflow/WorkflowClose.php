<?php

namespace App\Model\helpdesk\Workflow;

use App\BaseModel;

class WorkflowClose extends BaseModel
{
    protected $table = 'workflow_close';

    protected $fillable = ['id', 'days', 'condition', 'send_email', 'status', 'updated_at', 'created_at'];
}
