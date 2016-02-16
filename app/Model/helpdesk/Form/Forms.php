<?php

namespace App\Model\helpdesk\Form;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model {

    protected $table = 'custom_forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['formname'];

}
