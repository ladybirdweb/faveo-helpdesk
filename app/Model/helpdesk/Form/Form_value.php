<?php

namespace App\Model\helpdesk\Form;

use App\BaseModel;

class Form_value extends BaseModel
{
    public $timestamps = false;

    protected $table = 'form_value';

    protected $fillable = ['id', 'values'];
}
