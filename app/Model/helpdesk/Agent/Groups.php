<?php

namespace App\Model\helpdesk\Agent;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'permision';
    protected $fillable = [
        'user_id', 'permision',
    ];

    public function getPermisionAttribute($value)
    {
        if ($value) {
            $value = json_decode($value, true);
        }

        return $value;
    }

    public function setPermisionAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $this->attributes['permision'] = $value;
    }
}
