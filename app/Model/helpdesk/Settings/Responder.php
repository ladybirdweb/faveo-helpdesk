<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Responder extends BaseModel
{
    /* Using auto_response table  */

    protected $table = 'settings_auto_response';

    /* Set fillable fields in table */
    protected $fillable = [

        'id', 'new_ticket', 'agent_new_ticket', 'submitter', 'participants', 'overlimit',
    ];
}
