<?php

namespace App\Model\helpdesk\Notification;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'message', 'by', 'to', 'seen', 'table', 'row_id', 'url',
    ];

    public function setByAttribute($value)
    {
        if (!$value) {
            $this->attributes['by'] = 'System';
        } else {
            $this->attributes['by'] = $value;
        }
    }

    public function requester()
    {
        $related = 'App\User';

        return $this->belongsTo($related, 'by');
    }

    public function getMessageAttribute($value)
    {
        if ($value) {
            return strip_tags($value);
        } else {
            return $value;
        }
    }

    public function getCreatedAtAttribute($value)
    {
        if ($value) {
            return faveoDate($value);
        } else {
            return $value;
        }
    }
}
