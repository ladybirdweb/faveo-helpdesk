<?php

namespace App\Model\helpdesk\Workflow;

use Illuminate\Database\Eloquent\Model;

class WorkflowClose extends Model
{
    protected $table = 'workflow_close';
    protected $fillable = ['id', 'days', 'condition', 'send_email','status', 'updated_at', 'created_at'];
}
