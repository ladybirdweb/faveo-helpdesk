<?php

namespace App\Model\helpdesk\Form;

use Illuminate\Database\Eloquent\Model;

class FieldValue extends Model
{
    protected $table = 'field_values';

    protected $fillable = ['field_id', 'child_id', 'field_key', 'field_value'];

    public function childId()
    {
        $childid = '';
        $child = $this->attributes['child_id'];
        if ($child) {
            $childid = $this->attributes['child_id'];
        }

        return $childid;
    }
}
