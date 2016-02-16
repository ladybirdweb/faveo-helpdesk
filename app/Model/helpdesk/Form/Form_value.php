<?php

namespace App\Model\helpdesk\Form;

use Illuminate\Database\Eloquent\Model;

class Form_value extends Model {

    public $timestamps = false;
    protected $table = 'form_value';
    protected $fillable = ['id', 'values'];

}
