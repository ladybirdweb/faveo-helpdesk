<?php

namespace App\Plugins\Podio\Model;

use Illuminate\Database\Eloquent\Model;

class PodioTicket extends Model
{
    protected $table = 'podio_ticket_item';

    protected $fillable = ['ticket_id', 'podio_item_id'];

    // public function setFacebookCallbackUrlAttribute($value)
    // {
    //     $this->attributes['facebook_callback_url'] = str_finish($value, '/');
    // }
}
