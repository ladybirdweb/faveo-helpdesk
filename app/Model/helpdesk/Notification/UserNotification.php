<?php

namespace App\Model\helpdesk\Notification;

use App\BaseModel;

class UserNotification extends BaseModel
{
    protected $table = 'user_notification';

    protected $fillable = [

        'notification_id', 'user_id', 'is_read',
    ];

    public function notification()
    {
        $related = 'App\Model\helpdesk\Notification\Notification';
        $id = 'notification_id';

        return $this->belongsTo($related, $id);
    }

    public function users()
    {
        $related = 'App\User';
        $id = 'user_id';

        return $this->belongsTo($related, $id);
    }

//    public function delete() {
//        //$this->notification()->delete();
//        parent::delete();
//    }
}
