<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Model\helpdesk\Notification\Notification;
use App\Model\helpdesk\Notification\UserNotification;
use App\User;

class NotificationController extends Controller
{
    public $user;

    public function __construct()
    {
        $user = new User();
        $this->user = $user;
    }

    /**
     * get the page to list the notifications.
     *
     * @return response
     */
    public static function getNotifications()
    {
        $notifications = UserNotification::join('notifications', 'user_notification.notification_id', '=', 'notifications.id')
                ->join('notification_types', 'notifications.type_id', '=', 'notification_types.id')
                ->where('user_notification.is_read', '=', '0')
                ->where('user_notification.user_id', '=', \Auth::user()->id)
                ->get();

        return $notifications;
    }

    public function create($model_id, $userid_created, $type_id, $forwhome = [])
    {
        try {
            if (empty($forwhome)) {
                $forwhome = $this->user->where('role', '!=', 'user')->get()->toArray();
            }
        //dd($forwhome);
        //system notification
            $notification = new Notification();
            $UN = new UserNotification();

            $notify = $notification->create(['model_id' => $model_id, 'userid_created' => $userid_created, 'type_id' => $type_id]);
            foreach ($forwhome as $agent) {
                $user_notify = $UN->create(['notification_id' => $notify->id, 'user_id' => $agent['id'], 'is_read' => 0]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    public function markRead($id)
    {
        $markasread = UserNotification::where('notification_id', '=', $id)->where('user_id', '=', \Auth::user()->id)->where('is_read', '=', '0')->get();
        foreach ($markasread as $mark) {
            $mark->is_read = '1';
            $mark->save();
        }

        return 1;
    }

    public function show()
    {
        $notifications = $this->getNotifications();

        return view('notifications-all', compact('notifications'));
    }

    public function delete($id)
    {
        $markasread = UserNotification::where('notification_id', '=', $id)->where('user_id', '=', \Auth::user()->id)->get();
        foreach ($markasread as $mark) {
            $mark->delete();
        }

        return 1;
    }
}
