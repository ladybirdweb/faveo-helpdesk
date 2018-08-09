<?php

namespace App\Http\Controllers\Agent\helpdesk\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Notification extends Controller
{
    public $alert;

    public function __construct()
    {
        $this->alert = new \App\Model\helpdesk\Settings\Alert();
    }

    public function isActive($key)
    {
        $check = false;
        if ($this->alert) {
            $new_ticket_alert = $this->alert->getValue($key);
            if ($new_ticket_alert == 1) {
                $check = true;
            }
        }

        return $check;
    }

    public function getPersons()
    {
        $key = $this->key.'_persons';
        $persons = [];
        if ($this->alert) {
            $person = $this->alert->getValue($key);
            if ($person) {
                $persons = explode(',', $person);
            }
        }

        return $persons;
    }

    public function getModes()
    {
        $key = $this->key.'_mode';
        $modes = [];
        if ($this->alert) {
            $mode = $this->alert->getValue($key);
            if ($mode) {
                $modes = explode(',', $mode);
            }
        }

        return $modes;
    }

    public function isMode($mode)
    {
        $check = false;
        $modes = $this->getModes();
        if (in_array($mode, $modes)) {
            $check = true;
        }

        return $check;
    }

    public function appNotification($userid)
    {
        $notification = \App\Model\helpdesk\Notification\Notification::with(['requester'=> function ($query) {
            return $query->select('first_name as changed_by_first_name', 'last_name as changed_by_last_name', 'user_name as changed_by_user_name', 'profile_pic', 'email', 'id'
                    );
        }])
        ->select('message', 'created_at', \DB::raw("find_in_set('$userid',notifications.seen) as seen"), 'id', 'url', 'by', 'table as senario', 'row_id', \DB::raw('created_at as created_utc'))
                ->whereRaw("find_in_set('$userid',notifications.to)")
                ->orderBy('notifications.id', 'desc')
                ->paginate(10)
                ->toJson();

        return  $notification;
    }

    public function notificationSeen($userid, Request $request)
    {
        $notifications = new \App\Model\helpdesk\Notification\Notification();
        $notificationid = $request->input('notification_id');
        $notifiction = $notifications->whereId($notificationid);
        $seen = $notifiction->select('seen')->value('seen');
        if ($seen) {
            $seen = $seen.','.$userid;
        } else {
            $seen = $userid;
        }

        return $notifiction->update(['seen' => $seen]);
    }

    public function notificationUnSeenCount($userid)
    {
        $notification = \App\Model\helpdesk\Notification\Notification::
                whereRaw("find_in_set('$userid',notifications.to)")
                ->select(
                        \DB::raw("find_in_set('$userid',notifications.seen) as seen"), \DB::raw("count(find_in_set('$userid',notifications.seen)) as seen_count")
                )
                ->groupBy('seen')
                ->get()
                ->whereIn('seen', ['0', 0])
                ->sum('seen_count');
        $result = ['count' => $notification];

        return response()->json($result, 200);
    }

    public function notificationUpdateSeenAll($userid)
    {
        try {
            \App\Model\helpdesk\Notification\Notification::
                    whereRaw("find_in_set('$userid',notifications.to)")
                    ->update(['seen' => ','.$userid]);
            $result = ['message' => 'Updated', 'response' => 'success'];
        } catch (\Exception $ex) {
            $result = ['message' => $ex->getMessage(), 'response' => 'fails'];
        }

        return response()->json($result, 200);
    }
}
