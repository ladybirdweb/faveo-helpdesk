<?php

namespace App\Model\helpdesk\Email;

use Illuminate\Database\Eloquent\Model;

class Smtp extends Model
{
    public $timestamps = false;
    protected $table = 'send_mail';
    protected $fillable = ['driver', 'port', 'host', 'encryption', 'name', 'email', 'password'];
}
