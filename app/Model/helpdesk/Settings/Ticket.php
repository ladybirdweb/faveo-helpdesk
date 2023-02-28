<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Ticket extends BaseModel
{
    /* Using Ticket table  */

    protected $table = 'settings_ticket';

    /* Set fillable fields in table */
    protected $fillable = [
        'id', 'num_format', 'num_sequence', 'priority', 'sla', 'help_topic', 'max_open_ticket', 'collision_avoid', 'lock_ticket_frequency',
        'captcha', 'status', 'claim_response', 'assigned_ticket', 'answered_ticket', 'agent_mask', 'html', 'client_update', 'max_file_size',
    ];
}
