<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class MailboxProtocol extends BaseModel
{
    public $timestamps = false;

    protected $table = 'mailbox_protocol';

    protected $fillable = ['id', 'name', 'value'];
}
