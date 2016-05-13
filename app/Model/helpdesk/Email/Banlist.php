<?php

namespace App\Model\helpdesk\Email;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Banlist extends BaseModel
{
    protected $table = 'banlist';
    protected $fillable = [
        'id', 'ban_status', 'email_address', 'internal_notes',
    ];
}
