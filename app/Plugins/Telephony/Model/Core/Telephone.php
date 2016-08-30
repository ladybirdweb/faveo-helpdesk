<?php

namespace App\Plugins\Telephony\Model\Core;

use Illuminate\Database\Eloquent\Model;

class Telephone extends Model {
    protected $table = "telephone_providers";
    protected $fillable = [
        'name',
        'short'
    ];
}
