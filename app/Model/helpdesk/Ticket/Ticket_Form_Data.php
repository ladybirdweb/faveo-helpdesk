<?php

namespace App\Model\helpdesk\Ticket;

use App\BaseModel;

class Ticket_Form_Data extends BaseModel
{
    protected $table = 'ticket_form_data';

    protected $fillable = ['id', 'ticket_id', 'title', 'content', 'created_at', 'updated_at'];

    public function getFieldKeyLabel()
    {
        $value = $this->attributes['title'];
        $fields = new \App\Model\helpdesk\Form\Fields();
        $field = $fields->where('name', $value)->first();
        if ($field) {
            $value = $field->label;
        }

        return $value;
    }

    public function isHidden()
    {
        $check = false;
        $value = $this->attributes['title'];
        $fields = new \App\Model\helpdesk\Form\Fields();
        $field = $fields->where('name', $value)->first();
        if ($field && $field->type == 'hidden') {
            $check = true;
        }

        return $check;
    }

    public function getHidden()
    {
        $value = $this->attributes['title'];
        $fields = new \App\Model\helpdesk\Form\Fields();
        $field = $fields->where('name', $value)->first();
        if ($field && $field->type == 'hidden') {
            return $field->label;
        }
    }
}
