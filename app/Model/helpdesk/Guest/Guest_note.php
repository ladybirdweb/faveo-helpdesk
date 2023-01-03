<?php

namespace App\Model\helpdesk\Guest;

use Illuminate\Database\Eloquent\Model;

class Guest_note extends Model
{
    public $timestamps = false;

    protected $table = 'guest_note';

    protected $fillable = ['id', 'heading', 'content'];
}
