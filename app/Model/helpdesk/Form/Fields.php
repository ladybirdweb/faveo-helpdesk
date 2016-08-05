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
        $related = "App\Model\helpdesk\Form\FieldValue";

        return $this->hasMany($related, 'field_id');
    }

    public function values()
    {
        $value = $this->valueRelation();

        return $value;
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
        parent::delete();
    }
}
