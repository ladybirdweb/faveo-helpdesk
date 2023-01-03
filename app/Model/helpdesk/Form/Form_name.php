<?php

namespace App\Model\helpdesk\Form;

use App\BaseModel;

class Form_name extends BaseModel
{
    public $timestamps = false;

    protected $table = 'form_name';

    protected $fillable = ['id', 'name', 'status', 'no_of_fields'];
}
