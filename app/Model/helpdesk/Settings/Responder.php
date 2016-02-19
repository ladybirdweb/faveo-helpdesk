<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;

class Responder extends Model
{
    /* Using auto_response table  */

    protected $table = 'settings_auto_response';
    /* Set fillable fields in table */
    protected $fillable = [

        'id', 'new_ticket', 'agent_new_ticket', 'submitter', 'participants', 'overlimit',
    ];
}
