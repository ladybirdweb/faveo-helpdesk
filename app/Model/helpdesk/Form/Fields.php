<?php

namespace App\Model\helpdesk\Form;

use App\BaseModel;

class Fields extends BaseModel
{
    protected $table = 'custom_form_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['forms_id', 'label', 'name', 'type', 'value', 'required'];

    public function valueRelation()
    {
        $related = \App\Model\helpdesk\Form\FieldValue::class;

        return $this->hasMany($related, 'field_id');
    }

    public function values()
    {
        $value = $this->valueRelation();

        return $value;
    }

    public function valuesAsString()
    {
        $string = '';
        $values = $this->values()->pluck('field_value')->toArray();
        if (count($values) > 0) {
            $string = implode(',', $values);
        }

        return $string;
    }

    public function requiredFieldForCheck()
    {
        $check = false;
        $required = $this->attributes['required'];
        if ($required === '1') {
            $check = true;
        }

        return $check;
    }

    public function nonRequiredFieldForCheck()
    {
        $check = false;
        $required = $this->attributes['required'];
        if ($required !== '1') {
            $check = true;
        }

        return $check;
    }

    public function deleteValues()
    {
        $values = $this->values()->get();
        if ($values->count() > 0) {
            foreach ($values as $value) {
                $value->delete();
            }
        }
    }

    public function delete()
    {
        $this->deleteValues();
        parent::delete();
    }
}
