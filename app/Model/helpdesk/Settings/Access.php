<?php

namespace App\Model\helpdesk\Settings;

use App\BaseModel;

class Access extends BaseModel
{
    protected $table = 'access';

    protected $fillable = [
        'password_expire', 'reg_method', 'user_session',
        'agent_session', 'reset_ticket_expire', 'password_reset',
        'bind_agent_ip', 'reg_require', 'quick_access',
    ];
}
