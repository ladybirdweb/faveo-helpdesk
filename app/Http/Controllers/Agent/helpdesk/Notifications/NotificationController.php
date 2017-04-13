<?php

namespace App\Http\Controllers\Agent\helpdesk\Notifications;

//models

//classes
use DB;
use Lang;
use Schema;

class NotificationController extends Notification
{
    public $ticketid = null;
    public $key = null;
    public $userid = null;
    public $message = null;
    public $variable = null;
    public $from = null;
    public $send_mail = true;
    public $change = [];
    public $model = null;
    public $content_saved_thread = null;
    public $authUserid = null;
    public $save_in_thread = true;

    public function saved($array)
    {
        $change = checkArray('changes', $array);
        if (checkArray('note', $change)) {
            $this->save_in_thread = false;
        }
        $model = checkArray('model', $array);
        if ($change && $model) {
            $this->authUserid = $model->user_id;
            $this->saveInThread($change, $model);
        }
    }

    public function saveInThread($change, $model)
    {
        $this->setParameter('change', $change);
        $this->setParameter('model', $model);
        $ticket_id = $this->getTicketId($model);
        $this->setParameter('ticketid', $ticket_id);
        $key = $this->getInternalKey($change);
        $this->key = $key;
        $body = $this->getBody($change, $model);
        //echo $body."<br>";
        $tickets = $this->ticket($ticket_id);
        $type = $this->type($tickets);
        $userid = $this->by($change, true);
        $user = $this->authUser();
        $poster = $this->poster($userid, true);
        $internal = 1;
        $notification = [];
        if ($body && $this->save_in_thread) {
            $thread = \App\Model\helpdesk\Ticket\Ticket_Thread::create([
                        'thread_type' => $type,
                        'body'        => $body,
                        'ticket_id'   => $ticket_id,
                        'is_internal' => $internal,
                        'user_id'     => $userid,
                        'poster'      => $poster,
            ]);
            $this->content_saved_thread_id = $thread;
        }
        $ticket_subject = $tickets->thread()->whereNotNull('title')->where('title', '!=', '')->select('title')->first();
        $this->setFrom($tickets);
        //dd($ticket_subject);
        if ($ticket_subject && $tickets && (count($change) > 1 || !checkArray('duedate', $change))) {
            $notification[] = [
                $key => [
                    'from'    => $this->from,
                    'message' => ['subject' => $ticket_subject->title.'[#'.$tickets->ticket_number.']',
                        'scenario'          => 'internal_change',
                    ],
                    'variable' => [
                        'internal_content' => $body,
                        'by'               => $user,
                    ],
                    'ticketid' => $ticket_id,
                ],
            ];
        }
        if (is_array($change) && (count($change) == 1) && array_key_exists('assigned_to', $change)) {
            $this->setParameter('send_mail', false);
        }
        if ($notification) {
            $this->setDetails($notification);
        }
    }

    public function getInternalKey($change)
    {
        $key = 'internal_activity_alert';
        if (is_array($change) && array_key_exists('dept_id', $change)) {
            $key = 'ticket_transfer_alert';
        }
        if (is_array($change) && array_key_exists('assigned_to', $change)) {
            $key = 'ticket_assign_alert';
        }
        $this->key = $key;

        return $key;
    }

    public function authUserid($key)
    {
        $id = null;
        if ($key == 'duedate') {
            return $id;
        }
        if (\Auth::user()) {
            $id = \Auth::user()->id;
        } elseif ($this->userid) {
            $id = $this->userid;
        }

        return $id;
    }

    public function authUser()
    {
        $name = 'System';
        if (\Auth::user()) {
            $name = \Auth::user()->name();
        }

        return $name;
    }

    public function poster($id, $force_support = false)
    {
        $poster = 'support';
        if ($id && $force_support == false) {
            $poster = 'client';
        }

        return $poster;
    }

    public function saveInNotification()
    {
        if ($this->isMode('system') && $this->model) {
            $message = $this->getBody($this->change, $this->model, true);
            //dd($this->change, $this->model, true,$message);
            $to_array = $this->getField('id', false);
//            echo "$this->key<br>";
            $to = '';
            if ($to_array->count() > 0) {
                $to = $to_array->implode(',');
            }
            $by = $this->by();
            if ($message) {
                //dd($message,$to,$by,$this->table($this->model),$this->rowId($this->model),$this->getUrl($this->model));
                \App\Model\helpdesk\Notification\Notification::create([
                    'message' => $message,
                    'to'      => $to,
                    'by'      => $by,
                    'table'   => $this->table($this->model),
                    'row_id'  => $this->rowId($this->model),
                    'url'     => $this->getUrl($this->model),
                ]);
                //$this->mobilePush($noti->id, $to_array);
            }
        }
    }

    public function mobilePush($notification_id, $to)
    {
        //dd($notification_id);
        $fcm = new \App\Http\Controllers\Common\PushNotificationController();
        $noti = \App\Model\helpdesk\Notification\Notification::
                where('id', $notification_id)
                ->with([
                    'requester' => function ($query) {
                        return $query->select('first_name', 'last_name', 'user_name', 'profile_pic', 'email', 'id');
                    }, ])
                ->select(
                        'notifications.message', 'notifications.created_at', 'notifications.table as scenario', 'by', 'notifications.id as notification_id', 'row_id as id'
                )
                ->first()
                ->toArray();
        \App\User::whereIn('id', $to)
                ->where('role', '!=', 'user')
                ->select('fcm_token', 'i_token')
                ->chunk(10, function ($agents) use ($noti, $fcm) {
                    foreach ($agents as $agent) {
                        $fcm->response($agent->token(), $noti);
                    }
                });
    }

    public function by($change = '', $null = false)
    {
        $by = $this->authUserid;

        if (!$by) {
            $by = $this->userid;
        }
        if (!$by && \Auth::user()) {
            $by = \Auth::user()->id;
        }
        if (!$by && $null == false) {
            $by = 'system';
        }
        if (!$by && $null != false) {
            $by = null;
        }

        return $by;
    }

    public function getUrl($model)
    {
        $table = $model->getTable();
        $id = $model->id;
        if ($table == 'ticket_thread') {
            $id = $model->ticket_id;
            $url = faveoUrl("thread/$id");
        }
        if ($table == 'tickets') {
            $url = faveoUrl("thread/$id");
        }
        if ($table == 'users') {
            $url = faveoUrl("user/$id");
        }

        return $url;
    }

    public function table($model)
    {
        $table = $model->getTable();
        if ($table == 'ticket_thread') {
            $table = 'tickets';
        }

        return $table;
    }

    public function rowId($model)
    {
        $table = $model->getTable();
        $id = $model->id;
        if ($table == 'ticket_thread') {
            $id = $model->ticket_id;
        }

        return $id;
    }

    public function send()
    {
        //echo "is active => ".$this->isActive($this->key)."<br>";
        if ($this->isActive($this->key)) {
            $this->sendEmail();
            $this->sendSms();
            $this->saveInNotification();
        }
    }

    public function sendEmail()
    {
        //echo "is mode email and this send mail => ".$this->isMode('email') && $this->send_mail."<br>";
        if ($this->isMode('email') && $this->send_mail) {
            $emails = $this->getField();
            //echo json_encode($emails)."<br>";
            foreach ($emails as $name => $email) {
                //echo $name." => ".$email."<br>";
                $this->postMail($email, $name);
            }
        }
    }

    public function getField($field = 'email', $schma = true, $collect = false, $collection_fields = '')
    {
        $persons = $this->getPersons();
        $collection = collect();
        $ticket = $this->getTicket();
        foreach ($persons as $person) {
            //echo $person."<br>";
            $collection->push($this->getAgentIdByDependency($person, $ticket));
        }
        $unique = $collection->flatten()->unique()->filter(function ($item) {
            return $item != null;
        });
        if ($schma == true) {
            $unique = \App\User::whereNotNull($field)->whereIn('id', $unique)->pluck($field, 'first_name')->toArray();
        }
        if ($collect == true) {
            if (count($collection_fields) > 0) {
                $unique = \App\User::whereNotNull($field)->select($collection_fields)->whereIn('id', $unique)->get();
            } else {
                $unique = \App\User::whereNotNull($field)->whereIn('id', $unique)->get();
            }
        }

        return $unique;
    }

    public function getAgentIdByDependency($person, $ticket)
    {
        $agents = [];
        switch ($person) {
            case 'department_members': // pass department id
                if ($ticket) {
                    $modelid = $ticket->dept_id;
                    $agents = \App\Model\helpdesk\Agent\DepartmentAssignAgents::where('department_assign_agents.department_id', $modelid)
                            ->join('users', 'department_assign_agents.agent_id', '=', 'users.id')
                            ->select('users.id as department_members')
                            ->where('users.active', '=', 1)
                            ->where('users.ban', '=', 0)
                            ->where('users.is_delete', '=', 0)
                            ->get()
                            ->toArray();
                }

                return $agents;
            case 'team_members': //pass team id
                if ($ticket) {
                    $modelid = $ticket->team_id;
                    $agents = \App\Model\helpdesk\Agent\Assign_team_agent::
                            where('team_assign_agent.team_id', $modelid)
                            ->join('users', 'team_assign_agent.agent_id', '=', 'users.id')
                            ->select('users.id as team_members')
                            ->where('users.active', '=', 1)
                            ->where('users.ban', '=', 0)
                            ->where('users.is_delete', '=', 0)
                            ->get()
                            ->toArray();
                }

                return $agents;
            case 'agent':
                $agents = \App\User::where('role', 'agent')
                        ->where('active', 1)
                        ->where('ban', 0)
                        ->where('is_delete', 0)
                        ->select('id')
                        ->get()
                        ->toArray();

                return $agents;
            case 'admin':
                $agents = \App\User::where('role', 'admin')
                        ->where('active', 1)
                        ->where('ban', 0)
                        ->where('is_delete', 0)
                        ->select('id as admin')
                        ->get()
                        ->toArray();

                return $agents;
            case 'user': // pass ticket user id
                if ($ticket) {
                    $modelid = $ticket->user()
                            ->where('active', 1)
                            ->where('ban', 0)
                            ->where('is_delete', 0)
                            ->value('id');
                    $agents = ['user' => $modelid];
                }

                return $agents;
            case 'agent_admin':
                $agents = \App\User::where('role', '!=', 'user')
                        ->where('active', 1)
                        ->where('ban', 0)
                        ->where('is_delete', 0)
                        ->select('id as agent_admin')
                        ->get()
                        ->toArray();

                return $agents;
            case 'department_manager'://pass department id
                if ($ticket) {
                    $modelid = $ticket->dept_id;
                    $agents = \App\Model\helpdesk\Agent\Department::where('department.id', $modelid)
                            ->join('users', 'department.manager', '=', 'users.id')
                            ->select('users.id as department_manager')
                            ->where('users.active', '=', 1)
                            ->where('users.ban', '=', 0)
                            ->where('users.is_delete', '=', 0)
                            ->get()
                            ->toArray();
                }

                return $agents;
            case 'team_lead': //pass team id
                if ($ticket) {
                    $modelid = $ticket->team_id;
                    $agents = \App\Model\helpdesk\Agent\Teams::where('teams.id', $modelid)
                            ->where('status', 1)
                            ->join('users', 'teams.team_lead', '=', 'users.id')
                            ->select('users.id as team_lead')
                            ->where('users.active', '=', 1)
                            ->where('users.ban', '=', 0)
                            ->where('users.is_delete', '=', 0)
                            ->get()
                            ->toArray();
                }

                return $agents;
            case 'organization_manager'://pass user id
                if ($ticket) {
                    $modelid = $ticket->user_id;
                } else {
                    $modelid = $this->userid;
                }
                if ($modelid) {
                    $org = \App\Model\helpdesk\Agent_panel\User_org::where('user_assign_organization.user_id', $modelid)
                            ->join('users', 'user_assign_organization.user_id', '=', 'users.id')
                            ->where('users.active', '=', 1)
                            ->where('users.ban', '=', 0)
                            ->where('users.is_delete', '=', 0)
                            ->select('user_assign_organization.org_id')
                            ->first();
                    if ($org) {
                        $orgid = $org->org_id;
                        $agents = \App\Model\helpdesk\Agent_panel\Organization::where('id', $orgid)->select('head as organization_manager')->get()->toArray();
                    }
                }

                return $agents;
            case 'last_respondent':
                if ($ticket) {
                    $agents = $ticket->thread()
                            ->whereNotNull('ticket_thread.user_id')
                            ->join('users', function ($join) {
                                return $join->on('ticket_thread.user_id', '=', 'users.id')
                                        ->where('users.active', '=', 1)
                                        ->where('users.ban', '=', 0)
                                        ->where('users.is_delete', '=', 0);
                            })
                            ->orderBy('ticket_thread.id', 'desc')
                            ->select('users.id as last_respondent')
                            ->first()
                            ->toArray();
                }

                return $agents;
            case 'assigned_agent_team':
                if ($ticket) {
                    $assigned = $ticket->assigned()
                            ->where('users.active', '=', 1)
                            ->where('users.ban', '=', 0)
                            ->where('users.is_delete', '=', 0)
                            ->value('id')
//                            ->get()
;
                    $agents = ['assigned_agent_team' => $assigned];
                }

                return $agents;
            case 'all_department_manager':
                $agents = \App\Model\helpdesk\Agent\Department::
                        select('department.manager as all_department_manager')
                        ->join('users', function ($join) {
                            $join->on('department.manager', '=', 'users.id')
                            ->where('users.active', '=', 1)
                            ->where('users.ban', '=', 0)
                            ->where('users.is_delete', '=', 0);
                        })
                        ->get()
                        ->toArray();

                return $agents;
            case 'all_team_lead':
                $agents = \App\Model\helpdesk\Agent\Teams::where('teams.status', 1)
                        ->join('users', function ($join) {
                            $join->on('teams.team_lead', '=', 'users.id')
                            ->where('users.active', '=', 1)
                            ->where('users.ban', '=', 0)
                            ->where('users.is_delete', '=', 0);
                        })
                        ->select('teams.team_lead as all_team_lead')
                        ->get()
                        ->toArray();

                return $agents;
            case 'client':
                //dd($this);
                if ($ticket) {
                    $agents = ['client' => $ticket->user_id];
                }
                if ($this->userid) {
                    $agents = ['client' => $this->userid];
                }

                return $agents;
        }
    }

    public function sendSms()
    {
        // if ($this->isMode('sms')) {
        //     //put check for SMS plugin and settings
        //     if ($this->checkPluginSetup()) {
        //         $users = $this->getField('mobile', false, true, ['user_name', 'first_name', 'last_name', 'role', 'id', 'email', 'mobile', 'country_code', 'active']);
        //         $grouped_users = $this->groupCollectionbyField($users, 'role', ['user_name', 'first_name', 'last_name', 'id', 'email', 'mobile', 'country_code', 'active']);
        //         $sms_controller = new \App\Plugins\SMS\Controllers\SendSMSController();
        //         $sms_controller->handleMessageSending($grouped_users, $this->key, $this->variable);
        //         dd("hi");
        //     } else {
        //         loging('aler & notification', Lang::get('lang.sms-plugin-not-active'), 'info');
        //     }
        // }
    }

    public function getTicketId($model)
    {
        switch ($model->getTable()) {
            case 'tickets':
                return $model->id;
            case 'ticket_thread':
                return $model->ticket_id;
        }
    }

    public function ticket($id)
    {
        return \App\Model\helpdesk\Ticket\Tickets::where('id', $id)->first();
    }

    public function getType($change)
    {
        if ($change) {
            if (checkArray('response_due', $change)) {
                return 'response_due';
            }
            if (checkArray('resolve_due', $change)) {
                return 'resolve_due';
            }

            return 'system';
        }
    }

    public function getBody($change, $model, $inapp = false)
    {
        $auth_username = 'System';
        if (\Auth::user()) {
            $auth_username = '<a href='.faveoUrl('user/'.\Auth::user()->id).'>'.\Auth::user()->user_name.'</a>';
        }

        return $this->getSchemas($change, $model, $auth_username, $inapp);
    }

    public function getSchemas($change, $model, $auth_username, $inapp)
    {
        //dd($change,$model);
        $content = '';
        if ($this->key == 'new_ticket_alert') {
            $content = trans('lang.created.ticket', ['subject' => '<b>'.title($model->id).'</b>', 'created_at' => faveoDate($model->created_at)]);
        } elseif (count($change) > 0) {
            foreach ($change as $key => $value) {
                $get_content = $this->getContent($key, $value, $model, $auth_username, $inapp);
                if ($get_content) {
                    $this->authUserid = $this->authUserid($key);
                    $content .= $get_content.',';
                }
            }
        } elseif ($model && $model->getTable() == 'users') {
            $content = trans('lang.new-user-register', ['name' => $model->name(), 'created' => faveoDate($model->created_at)]);
        } elseif ($model && $model->getTable() == 'ticket_thread' && ($this->key == 'reply_alert' || $this->key == 'reply_notification_alert')) {
            $this->authUserid = $model->user_id;
            $content = trans('lang.reply.notification', ['title' => ticketNumber($this->ticketid), 'created' => faveoDate($model->created_at)]);
        }
        //dd($content);
        return $content;
    }

    public function getContent($key, $value, $model, $auth_username, $inapp)
    {
        //dd($key,$value,$model->title);
        $new = $this->switchNewSchema($key, $value, $model, $auth_username);
        $old = $this->switchOldSchema($key, $value, $model, $auth_username);

        $created_at = \Carbon\Carbon::now()->tz(timezone());
        switch ($key) {
            case 'priority_id':
                if ($inapp == true) {
                    return trans('lang.notification.update.inapp', ['model' => 'Priority', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.update', ['model' => 'Priority', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new]);
            case 'source':
                if ($inapp == true) {
                    return trans('lang.notification.update.inapp', ['model' => 'Source', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.update', ['model' => 'Source', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new]);
            case 'title':
                if ($inapp == true) {
                    return trans('lang.notification.update.inapp', ['model' => 'Title', 'created_at' => faveoDate($created_at), 'old' => '<b>'.$model->title.'</b>', 'new' => '<b>'.$value.'</b>', 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.update', ['model' => 'Title', 'created_at' => faveoDate($created_at), 'old' => '<b>'.$model->title.'</b>', 'new' => '<b>'.$value.'</b>']);
            case 'help_topic_id':
                if ($inapp == true) {
                    return trans('lang.notification.update.inapp', ['model' => 'Help topic', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.update', ['model' => 'Help topic', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new]);
            case 'sla':
                if ($inapp == true) {
                    return trans('lang.notification.update.inapp', ['model' => 'SLA', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.update', ['model' => 'SLA', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new]);
            case 'status':
                if ($inapp == true) {
                    return trans('lang.notification.update.inapp', ['model' => 'Status', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.update', ['model' => 'Status', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new]);
            case 'assigned_to':
                if ($value == $this->authUserid) {
                    if ($inapp == true) {
                        return trans('lang.notification.assigned.myself.inapp', ['old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                    }

                    return trans('lang.notification.assigned.myself', ['old' => $old, 'new' => $new]);
                } else {
                    if ($inapp == true) {
                        return trans('lang.notification.assigned.inapp', ['old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                    }

                    return trans('lang.notification.assigned', ['old' => $old, 'new' => $new]);
                }
            case 'user_id':
                if ($this->model == 'tickets') {
                    if ($inapp == true) {
                        return trans('lang.notification.update.inapp', ['model' => 'Requester', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                    }

                    return trans('lang.notification.update', ['model' => 'Requester', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new]);
                }
                break;
            case 'dept_id':
                if ($inapp == true) {
                    return trans('lang.notification.update.inapp', ['model' => 'Department', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new, 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.update', ['model' => 'Department', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $new]);
            case 'duedate':
                if ($inapp == true) {
                    return trans('lang.notification.duedate.inapp', ['model' => 'Duedate', 'created_at' => faveoDate($created_at), 'old' => $old, 'new' => $value, 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.duedate', ['model' => 'Duedate', 'new' => $value]);
            case 'note':
                if ($inapp == true) {
                    return trans('lang.notification.note.inapp', ['model' => 'Internal Note', 'new' => $value, 'ticket' => ticketNumber($this->ticketid)]);
                }

                return trans('lang.notification.note', ['model' => 'Internal Note', 'new' => $value]);
        }
    }

    public function switchNewSchema($key, $value, $model, $auth_username)
    {
        switch ($key) {
            case 'priority_id':
                $priority = '';
                $schema = \App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', $value)->select('priority')->first();
                if ($schema) {
                    $priority = '<b>'.$schema->priority.'</b>';
                }

                return $priority;

            case 'source':
                $source = '';
                $schema = \App\Model\helpdesk\Ticket\Ticket_source::where('id', $value)->select('name')->first();
                if ($schema) {
                    $source = '<b>'.$schema->name.'</b>';
                }

                return $source;

            case 'title':
                return '<b>'.$value.'</b>';

            case 'help_topic_id':
                $topic = '';
                $schema = \App\Model\helpdesk\Manage\Help_topic::where('id', $value)->select('topic')->first();
                if ($schema) {
                    $topic = '<b>'.$schema->topic.'</b>';
                }

                return $topic;

            case 'sla':
                $sla = '';
                $schema = \App\Model\helpdesk\Manage\Sla\Sla_plan::where('id', $value)->select('name')->first();
                if ($schema) {
                    $sla = '<b>'.$schema->name.'</b>';
                }

                return $sla;

            case 'status':
                $status = '';
                $schema = \App\Model\helpdesk\Ticket\Ticket_Status::where('id', $value)->select('name')->first();
                if ($schema) {
                    $status = '<b>'.$schema->name.'</b>';
                }

                return $status;

            case 'assigned_to':
                $assigned = '';
                $schema = \App\User::where('id', $value)->select('first_name', 'last_name', 'user_name')->first();
                if ($schema) {
                    $assigned = '<b>'.$schema->name().'</b>';
                }

                return $assigned;
            case 'user_id':
                $user = '';
                $schema = \App\User::where('id', $value)->select('first_name', 'last_name', 'user_name')->first();
                if ($schema) {
                    $user = '<b>'.$schema->name().'</b>';
                }

                return $user;
            case 'dept_id':
                $department = '';
                $schema = \App\Model\helpdesk\Agent\Department::where('id', $value)->select('name')->first();
                if ($schema) {
                    $department = '<b>'.$schema->name.'</b>';
                }

                return $department;
        }
    }

    public function switchOldSchema($key, $value, $model, $auth_username)
    {
        switch ($key) {
            case 'priority_id':
                $schema = $model->priority()->select('priority', 'priority_id')->first();
                if ($schema) {
                    return '<b>'.$schema->priority.'</b>';
                }

            case 'source':
                $source = '';
                $schema = $model->sources()->select('name', 'id')->first();
                if ($schema) {
                    $source = '<b>'.$schema->name.'</b>';
                }

                return $source;

            case 'title':
                $title = '';
                $schema = $model->whereNotNull('title')->select('title')->first();
                if ($schema) {
                    $title = '<b>'.$schema->title.'</b>';
                }

                return $title;

            case 'help_topic_id':
                $topic = '';
                $schema = $model->helptopic()->select('topic')->first();
                if ($schema) {
                    $topic = '<b>'.$schema->topic.'</b>';
                }

                return $topic;

            case 'sla':
                $sla = '';
                $schema = $model->slaPlan()->select('name')->first();
                if ($schema) {
                    $sla = '<b>'.$schema->name.'</b>';
                }

                return $sla;

            case 'status':
                $status = '';
                $schema = $model->statuses()->select('name')->first();
                if ($schema) {
                    $status = '<b>'.$schema->name.'</b>';
                }

                return $status;

            case 'assigned_to':
                $assigned = '';
                $schema = $model->assigned()->select('user_name')->first();
                if ($schema) {
                    $assigned = '<b>'.$schema->name().'</b><';
                }

                return $assigned;
            case 'user_id':
                $user = '';
                $schema = $model->user()->select('user_name')->first();
                if ($schema) {
                    $user = '<b>'.$schema->name().'</b>';
                }

                return $user;

            case 'dept_id':
                $department = '';
                $schema = $model->departments()->select('name')->first();
                if ($schema) {
                    $department = '<b>'.$schema->name.'</b>';
                }

                return $department;
        }
    }

    public function setParameters($array)
    {
        if (is_array($array) && count($array) > 0) {
            if (checkArray('ticketid', $array)) {
                $this->ticketid = checkArray('ticketid', $array);
            }
            $this->key = checkArray('key', $array);
            $this->userid = checkArray('userid', $array);
            $this->from = checkArray('from', $array);
            $this->message = checkArray('message', $array);
            $this->variable = checkArray('variable', $array);
            if (checkArray('send_mail', $array)) {
                $this->send_mail = checkArray('send_mail', $array);
            }
            if (checkArray('change', $array)) {
                $this->change = checkArray('change', $array);
            }
            if (checkArray('model', $array)) {
                $this->model = checkArray('model', $array);
            }
        }
    }

    public function setParameter($key, $value)
    {
        if ($key) {
            $this->$key = $value;
        }
    }

    public function getTicket()
    {
        if ($this->model && $this->model->getTable() == 'tickets') {
            return $this->model;
        }
        $tickets = new \App\Model\helpdesk\Ticket\Tickets();
        $ticket = $tickets->find($this->ticketid);
        if ($ticket) {
            return $ticket;
        }
    }

    public function postMail($to_email, $to_name)
    {
        $mail = new \App\Http\Controllers\Common\PhpMailController();
        $this->variable['agent'] = $to_name;
        $this->variable['ticket_agent_name'] = $to_name;
        $to = ['email' => $to_email, 'name' => $to_name];
        $mail->sendmail($this->from, $to, $this->message, $this->variable);
        loging('aler & notification', 'Alert email has sent to '.json_encode($to).'with '.json_encode([$this->message, $this->variable]), 'info');
    }

    public function setDetails($array)
    {
        $collection = array_collapse($array);
        if (count($collection) > 0) {
            foreach ($collection as $key => $value) {
                if ($key == 'registration_notification_alert') {
                    $key = 'registration_alert';
                }

                $from = checkArray('from', $value);
                $message = checkArray('message', $value);
                $variables = checkArray('variable', $value);
                $ticketid = checkArray('ticketid', $value);
                $send_mail = checkArray('send_mail', $value);
                $userid = checkArray('userid', $value);
                $model = checkArray('model', $value);
                $this->setParameters([
                    'ticketid'  => $ticketid,
                    'key'       => $key,
                    'from'      => $from,
                    'message'   => $message,
                    'variable'  => $variables,
                    'send_mail' => $send_mail,
                    'userid'    => $userid,
                    'model'     => $model,
                        ]
                );
                if ($key === 'new_user_alert' || $key === 'new_ticket_alert') {
                    $this->authUserid = $userid;
                    $this->userid = $userid;
                }
//                echo $key."<br>";
                $this->send();
//                echo "<hr>";
            }

//            dd('yes');
        }
    }

    public function setFrom($ticket)
    {
        $phpmail = new \App\Http\Controllers\Common\PhpMailController();
        $from = $phpmail->mailfrom('1', $ticket->dept_id);
        $this->from = $from;
    }

    public function type($ticket)
    {
        $type = $this->key;
        if ($ticket && is_array($this->change) && array_key_exists('duedate', $this->change)) {
            $type = 'response_due';
            if ($ticket->isanswered == 1) {
                $type = 'resolve_due';
            }
        }

        return $type;
    }

    /**
     * @category function to check is msg91 settins has been set up or not
     *
     * @param null
     *
     * @return null
     */
    public function checkPluginSetup()
    {
        //put check for SMS plugin and settings
        $sms_pluign_status = DB::table('plugins')->select('status')->where('name', '=', 'SMS')->first();
        if ($sms_pluign_status) {
            if (in_array("App\Plugins\SMS\ServiceProvider", \Config::get('app.providers'))) {
                if (Schema::hasTable('sms')) {
                    $sms = DB::table('sms')->get();
                    if (count($sms) > 0) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function groupCollectionbyField($users, $field, $show_field = ['email'])
    {
        if ($this->keysExistsinCollectionArray($users, $show_field) && $this->keysExistsinCollectionArray($users, $field)) {
            $tmp = [];
            foreach ($users as $user) {
                $tmp[$user[$field]][] = $this->setArrayValues($user, $show_field);
            }
        }

        return $tmp;
    }

    public function keysExistsinCollectionArray($collection_array, $keys)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                if (!array_key_exists($key, $collection_array->toArray()[0])) {
                    return false;
                }
            }

            return true;
        } else {
            return array_key_exists($keys, $collection_array->toArray()[0]);
        }
    }

    public function setArrayValues($user, $fields)
    {
        $array = [];
        foreach ($fields as $field) {
            $array[$field] = $user[$field];
        }

        return $array;
    }

    public function notificationSla()
    {
        $this->key = 'sla_alert';
        $this->approachSla();
        $this->violatedSla();
    }

    public function approachSla()
    {
        $agents = [];
        $now = \Carbon\Carbon::now();
        $now_plus_30 = \Carbon\Carbon::now()->addMinutes(30);
        echo $now."\n";
        $approach_tickets = \App\Model\helpdesk\Ticket\Tickets::
                where('duedate', '>', $now)
                ->select('id', 'user_id', 'assigned_to', 'dept_id', 'team_id', 'duedate', 'ticket_number')
                ->cursor();
        foreach ($approach_tickets as $ticket) {
            echo $ticket->duedate.'<'.$now_plus_30."\n";
            if ($ticket->duedate < $now_plus_30) {
                echo "due_approach => TRUE\n";
                $this->model = $ticket;
                $this->dispatchEmail('due_approach');
            }
        }
    }

    public function violatedSla()
    {
        $agents = [];
        $now = \Carbon\Carbon::now();
        $now_plus_30 = \Carbon\Carbon::now()->addMinutes(15);
        $now_minus_30 = \Carbon\Carbon::now()->subMinutes(15);
        $approach_tickets = \App\Model\helpdesk\Ticket\Tickets::
                where('duedate', '<', $now)
                ->select('id', 'user_id', 'assigned_to', 'dept_id', 'team_id', 'duedate', 'ticket_number')
                ->cursor();
        foreach ($approach_tickets as $ticket) {
            echo $now_minus_30.'<'.$ticket->duedate.'<'.$now_plus_30."\n";
            if ($now_minus_30 < $ticket->duedate && $ticket->duedate < $now_plus_30) {
                echo "due_violate => TRUE\n";
                $this->model = $ticket;
                $this->dispatchEmail('due_violate');
            }
        }
    }

    public function dispatchEmail($scenario)
    {
        if ($this->model) {
            $title = '';
            $requester = '';
            $thread = $this->model->thread()->whereNotNull('title')->where('title', '!=', '')->where('is_internal', 0)->first();
            if ($thread) {
                $title = $thread->title;
            }
            if ($this->model->user) {
                $requester = $this->model->user->first_name.' '.$this->model->user->last_name;
                if (!$this->model->user->first_name) {
                    $requester = $this->model->user->user_name;
                }
            }
            $mail = new \App\Http\Controllers\Common\PhpMailController();
            $this->from = $mail->mailfrom('1', $this->model->dept_id);
            $this->message = ['subject' => null, 'scenario' => $scenario];
            $this->variable = [
                'ticket_number'           => $this->model->ticket_number,
                'ticket_link_with_number' => faveoUrl('thread/'.$this->model->id),
                'title'                   => $title,
                'requester'               => $requester,
                'duedate'                 => $this->model->duedate->tz(timezone()),
            ];

            $this->sendEmail();

            echo "\n----------------\n";
        }
    }
}
