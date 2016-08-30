<?php

namespace App\Plugins\Telephony\Model\Core;

use Illuminate\Database\Eloquent\Model;

class TelephoneCall extends Model {
    protected $table = "telephone_calls";
    protected $fillable = [
        'callid',
        'provider',
        'key',
        'value',
    ];
}
