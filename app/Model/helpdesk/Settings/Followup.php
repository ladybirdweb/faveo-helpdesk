<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Followup extends BaseModel
{
    /* Using auto_response table  */

    protected $table = 'followup';

    /* Set fillable fields in table */
    protected $fillable = [

        'id', 'name', 'status', 'condition', 'created_at', 'updated_at',
    ];
}
