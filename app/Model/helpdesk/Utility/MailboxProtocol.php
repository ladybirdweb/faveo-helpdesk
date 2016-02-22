<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class MailboxProtocol extends Model
{
    public $timestamps = false;
    protected $table = 'mailbox_protocol';
    protected $fillable = ['id', 'name', 'value'];
}
