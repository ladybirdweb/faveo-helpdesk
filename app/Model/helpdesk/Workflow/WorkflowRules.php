<?php

namespace App\Model\helpdesk\Workflow;

use App\BaseModel;

class WorkflowRules extends BaseModel
{
    public $timestamps = false;

    protected $table = 'workflow_rules';

    protected $fillable = ['id', 'workflow_id', 'matching_criteria', 'matching_scenario', 'matching_relation', 'matching_value', 'updated_at', 'created_at'];
}
