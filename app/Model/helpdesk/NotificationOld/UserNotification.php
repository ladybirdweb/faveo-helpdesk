<?php

namespace App\Model\helpdesk\Notification;

use App\BaseModel;

class UserNotification extends BaseModel
{
    protected $table = 'user_notification';

    protected $fillable = [

        'notification_id', 'user_id', 'is_read',
    ];
}
