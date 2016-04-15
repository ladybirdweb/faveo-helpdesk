<?php

namespace App\Model\helpdesk\Notification;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $table = 'notification_types';
    protected $fillable = [

            'message', 'type', 'icon_class',
                            ];
}
