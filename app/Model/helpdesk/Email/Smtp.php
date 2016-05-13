<?php

namespace App\Model\helpdesk\Email;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Smtp extends BaseModel
{
    public $timestamps = false;
    protected $table = 'send_mail';
    protected $fillable = ['driver', 'port', 'host', 'encryption', 'name', 'email', 'password'];
}
