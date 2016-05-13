<?php

namespace App\Model\helpdesk\Notification;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class NotificationType extends BaseModel
{
    protected $table = 'notification_types';
    protected $fillable = [

            'message', 'type', 'icon_class',
                            ];
}
