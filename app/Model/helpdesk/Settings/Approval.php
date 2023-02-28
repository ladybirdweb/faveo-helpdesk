<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Approval extends BaseModel
{
    /* Using Ticket table  */

    protected $table = 'approval';

    /* Set fillable fields in table */
    protected $fillable = [
        'id', 'name', 'status', 'created_at', 'updated_at',
    ];
}
