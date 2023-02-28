<?php

namespace App\Model\helpdesk\Notification;

use App\BaseModel;

class Notification extends BaseModel
{
    protected $table = 'notifications';

    protected $fillable = [

        'model_id', 'userid_created', 'type_id',
    ];

    public function type()
    {
        $related = \App\Model\helpdesk\Notification\NotificationType::class;
        $id = 'type_id';

        return $this->belongsTo($related, $id);
    }

    public function model()
    {
        $related = \App\Model\helpdesk\Ticket\Tickets::class;
        $id = 'model_id';

        return $this->belongsTo($related, $id);
    }

    public function userNotification()
    {
        $related = \App\Model\helpdesk\Notification\UserNotification::class;
        $foreignKey = 'notification_id';

        return $this->hasMany($related, $foreignKey);
    }

    public function deleteUserNotification()
    {
        $user_notifications = $this->userNotification;
        if (count($user_notifications) > 0) {
            foreach ($user_notifications as $noti) {
                $noti->delete();
            }
        }
    }

    public function dummyDelete()
    {
        $user_notifications = UserNotification::get();
        if (count($user_notifications) > 0) {
            foreach ($user_notifications as $noti) {
                $noti->delete();
            }
        }
    }

    public function delete()
    {
        $this->deleteUserNotification();
        // $this->dummyDelete();
        parent::delete();
    }
}
