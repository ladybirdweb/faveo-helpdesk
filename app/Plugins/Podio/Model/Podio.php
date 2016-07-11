<?php

namespace App\Plugins\Podio\Model;

use Illuminate\Database\Eloquent\Model;

class Podio extends Model
{
    protected $table = 'podio';

    protected $fillable = ['client_id', 'client_secrete',
                           'app_id', 'app_token',
                           'username', 'password', ];

    // public function setFacebookCallbackUrlAttribute($value)
    // {
    //     $this->attributes['facebook_callback_url'] = str_finish($value, '/');
    // }
}
