<?php

namespace App\Model\helpdesk\Form;

use Illuminate\Database\Eloquent\Model;

class FieldValue extends Model
{
    protected $table = 'field_values';
    protected $fillable = ['field_id', 'parent_id', 'field_key', 'field_value'];
}
