<?php

namespace App\Model\helpdesk\Form;

use Illuminate\Database\Eloquent\Model;

class Form_name extends Model
{
    public $timestamps = false;
    protected $table = 'form_name';
    protected $fillable = ['id', 'name', 'status', 'no_of_fields'];
}
