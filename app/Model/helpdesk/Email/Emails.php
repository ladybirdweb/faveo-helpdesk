<?php

namespace App\Model\helpdesk\Email;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Emails extends BaseModel
{
    protected $table = 'emails';
    protected $fillable = [
        'email_address', 'email_name', 'department', 'priority', 'help_topic',
        'user_name', 'password', 'fetching_host', 'fetching_port', 'fetching_protocol', 'fetching_encryption', 'mailbox_protocol',
        'folder', 'sending_host', 'sending_port', 'sending_protocol', 'sending_encryption', 'internal_notes', 'auto_response',
        'fetching_status', 'move_to_folder', 'delete_email', 'do_nothing',
        'sending_status', 'authentication', 'header_spoofing', 'imap_config',
    ];
}
