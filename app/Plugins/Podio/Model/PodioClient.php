<?php

namespace App\Plugins\Podio\Model;

use Illuminate\Database\Eloquent\Model;

class PodioClient extends Model
{
    protected $table = 'podio_client_item';

    protected $fillable = ['user_id', 'podio_item_id'];

    // public function setFacebookCallbackUrlAttribute($value)
    // {
    //     $this->attributes['facebook_callback_url'] = str_finish($value, '/');
    // }
}
