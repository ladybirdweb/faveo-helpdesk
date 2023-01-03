<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdditionalInfo extends Model
{
    protected $table = 'user_additional_infos';

    protected $fillable = ['owner', 'service', 'key', 'value'];
}
