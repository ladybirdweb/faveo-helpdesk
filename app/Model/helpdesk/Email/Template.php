<?php

namespace App\Model\helpdesk\Email;

use App\BaseModel;

class Template extends BaseModel
{
    protected $table = 'template';

    protected $fillable = [
        'id', 'name', 'status', 'template_set_to_clone', 'language', 'internal_note',
    ];
}
