<?php

namespace App\Model\helpdesk\Notification;

use App\BaseModel;

class NotificationType extends BaseModel
{
    protected $table = 'notification_types';

    protected $fillable = [

        'message', 'type', 'icon_class',
    ];
}
