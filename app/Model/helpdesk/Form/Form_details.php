<?php

namespace App\Model\helpdesk\Form;

use App\BaseModel;

class Form_details extends BaseModel
{
    public $timestamps = false;

    protected $table = 'form_details';

    protected $fillable = ['id', 'label', 'type'];
}
