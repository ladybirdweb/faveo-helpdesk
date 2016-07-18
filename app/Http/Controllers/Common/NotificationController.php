<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Model\helpdesk\Notification\Notification;
use App\Model\helpdesk\Notification\UserNotification;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;

class NotificationController extends Controller {
    /**
     ********************************************* 
     * Class Notification Controller
     *********************************************
     * This controller is used to generate in app notification
     * under the folling occurrence 
     * 1. Ticket Creation
     * 2. Ticket Reply
     * 3. User Creation
     * 
     * @author      Ladybird <info@ladybirdweb.com>
     */
    
    public $user;

    /**
    * Constructor
    */
    public function __construct() {
        $user = new User();
        $this->user = $user;
        // checking authentication
        $this->middleware('auth');
        // checking if role is agent
        $this->middleware('role.agent');
    }

    /**
     * This function is used to create in app notifications.
     * @param type $model_id
     * @param type $userid_created
     * @param type $type_id
     * @param type $forwhome
     */
    public function create($model_id, $userid_created, $type_id, $forwhome = []) {
        try {
//            dd($model_id);
            if (empty($forwhome)) {
                $ticket = Tickets::where('id', '=', $model_id)->first();
                $forwhome = $this->user->where('role', '!=', 'user')->where('primary_dpt', '=', $ticket->dept_id)->get();
            }
            //system notification
            $notify = Notification::create(['model_id' => $model_id, 'userid_created' => $userid_created, 'type_id' => $type_id]);
            foreach ($forwhome as $agent) {
                UserNotification::create(['notification_id' => $notify->id, 'user_id' => $agent['id'], 'is_read' => 0]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * This function is to mark all ticket to read status
     * @param type $id
     * @return int
     */
    public function markAllRead($id) {
        $markasread = UserNotification::where('user_id', '=', \Auth::user()->id)->where('is_read', '=', '0')->get();
        foreach ($markasread as $mark) {
            $mark->is_read = '1';
            $mark->save();
        }
        return 1;
    }

    /**
     * This function to mark read
     * @param type $id
     * @return int
     */
    public function markRead($id) {
        $markasread = UserNotification::where('notification_id', '=', $id)->where('user_id', '=', \Auth::user()->id)->where('is_read', '=', '0')->get();
        foreach ($markasread as $mark) {
            $mark->is_read = '1';
            $mark->save();
        }
        return 1;
    }

    /**
     * function to show all the notifications
     * @return type
     */
    public function show() {
        $notifications = $this->getNotifications();
        return view('notifications-all', compact('notifications'));
    }

    /**
     * function to delete notifications
     * @param type $id
     * @return int
     */
    public function delete($id) {
        $markasread = UserNotification::where('notification_id', '=', $id)->where('user_id', '=', \Auth::user()->id)->get();
        foreach ($markasread as $mark) {
            $mark->delete();
        }

        return 1;
    }

    /**
     * get the page to list the notifications.
     * @return response
     */
    public static function getNotifications() {
        $notifications = UserNotification::join('notifications', 'user_notification.notification_id', '=', 'notifications.id')
                ->join('notification_types', 'notifications.type_id', '=', 'notification_types.id')
                ->where('user_notification.user_id', '=', \Auth::user()->id)
                ->paginate(10);
        return $notifications;
    }

}
