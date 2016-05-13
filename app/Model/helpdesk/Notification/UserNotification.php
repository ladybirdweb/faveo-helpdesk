<?php

namespace App\Model\helpdesk\Notification;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class UserNotification extends BaseModel
{
    protected $table = 'user_notification';
    protected $fillable = [

            'notification_id', 'user_id', 'is_read',
                            ];
}
