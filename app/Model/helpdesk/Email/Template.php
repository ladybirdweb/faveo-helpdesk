<?php

namespace App\Model\helpdesk\Email;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'template';
    protected $fillable = [
        'id', 'name', 'status', 'template_set_to_clone', 'language', 'internal_note',
    ];
}
