<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Alert extends BaseModel
{
    /* Using alert_notice table  */

    protected $table = 'settings_alert_notice';

    /* Set fillable fields in table */
    protected $fillable = [

        'id', 'ticket_status', 'ticket_admin_email', 'ticket_department_manager',
        'ticket_organization_accmanager', 'message_status', 'message_last_responder', 'message_assigned_agent',
        'message_department_manager', 'message_organization_accmanager', 'internal_status', 'internal_last_responder',
        'internal_assigned_agent', 'internal_department_manager', 'assignment_status', 'assignment_assigned_agent',
        'assignment_team_leader', 'assignment_team_member', 'transfer_status', 'transfer_assigned_agent', 'transfer_department_manager',
        'transfer_department_member', 'overdue_status', 'overdue_assigned_agent', 'overdue_department_manager',
        'overdue_department_member', 'system_error', 'sql_error', 'excessive_failure',
    ];
}
