<?php

namespace App\Plugins\Telephony\Model\Core;

use Illuminate\Database\Eloquent\Model;

class TelephoneDetail extends Model
{
    protected $table = 'telephone_details';
    protected $fillable = [
        'provider',
        'key',
        'value',
    ];

    public function setTicketIdAttribute($value)
    {
        if ($value == '') {
            $value = null;
        }
        $this->attributes['ticket_id'] = $value;
    }

    public function getValue($short, $key)
    {
        $value = '';
        $detail = $this->where('provider', $short)->where('key', $key)->first();
        if ($detail) {
            $value = $detail->value;
        }

        return $value;
    }
}
