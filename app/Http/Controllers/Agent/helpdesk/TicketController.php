<?php

namespace App\Http\Controllers\Agent\helpdesk;

// controllers
use App\Http\Controllers\Common\FileuploadController;
use App\Http\Controllers\Common\NotificationController as Notify;
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\CreateTicketRequest;
use App\Http\Requests\helpdesk\TicketRequest;
// models
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Teams;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Manage\Tickettype;
use App\Model\helpdesk\Notification\Notification;
use App\Model\helpdesk\Notification\UserNotification;
use App\Model\helpdesk\Settings\Alert;
use App\Model\helpdesk\Settings\CommonSettings;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\Email;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Collaborator;
use App\Model\helpdesk\Ticket\Ticket_Form_Data;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Utility\CountryCode;
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\User;
use Auth;
use DB;
// classes
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\support\Collection;
use Input;
use Lang;
use Mail;
use PDF;

/**
 * TicketController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class TicketController extends Controller
{
    protected $ticket_policy;

    /**
     * Create a new controller instance.
     *
     * @return type response
     */
    public function __construct()
    {
        $this->PhpMailController = new PhpMailController();
        $this->NotificationController = new Notify();
        $this->middleware('auth');
        $this->ticket_policy = new \App\Policies\TicketPolicy();
    }

    /**
     * @category function to return datatable object
     *
     * @param null
     *
     * @return object
     */
    public function getTableFormat()
    {
        return \Datatable::table()
                        ->addColumn(
                                '<a class="checkbox-toggle"><i class="fa fa-square-o fa-2x"></i></a>', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity')
                        )
                        ->noScript();
    }

    /**
     * @category function to return ticket view page
     *
     * @param null
     *
     * @return repsone/view
     */
    public function getTicketsView()
    {
        $table = $this->getTableFormat();
        $ticket_policy = $this->ticket_policy;

        return view('themes.default1.agent.helpdesk.ticket.tickets', compact('table', 'ticket_policy'));
    }

    /**
     * Show the Inbox ticket list page.
     *
     * @return type response
     */
    public function inbox_ticket_list()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.inbox', compact('table'));
    }

    /**
     * Show the Open ticket list page.
     *
     * @return type response
     */
    public function open_ticket_list()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.open', compact('table'));
    }

    /**
     * Show the answered ticket list page.
     *
     * @return type response
     */
    public function answered_ticket_list()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.answered', compact('table'));
    }

    /**
     * Show the Myticket list page.
     *
     * @return type response
     */
    public function myticket_ticket_list()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.myticket', compact('table'));
    }

    /**
     * Show the Overdue ticket list page.
     *
     * @return type response
     */
    public function overdue_ticket_list()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.overdue', compact('table'));
    }

    /**
     * Show the Open ticket list page.
     *
     * @return type response
     */
    public function dueTodayTicketlist()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.duetodayticket', compact('table'));
    }

    /**
     * Show the Closed ticket list page.
     *
     * @return type response
     */
    public function closed_ticket_list()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.closed', compact('table'));
    }

    /**
     * Show the ticket list page.
     *
     * @return type response
     */
    public function assigned_ticket_list()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.assigned', compact('table'));
    }

    /**
     * Show the New ticket page.
     *
     * @return type response
     */
    public function newticket(CountryCode $code)
    {
        if (!$this->ticket_policy->create()) {
            return redirect('dashboard')->with('fails', Lang::get('lang.permission-denied'));
        }

        return view('themes.default1.agent.helpdesk.ticket.new');
    }

    /**
     * Save the data of new ticket and show the New ticket page with result.
     *
     * @param type CreateTicketRequest $request
     *
     * @return type response
     */
    public function post_newticket(CreateTicketRequest $request, CountryCode $code, $api
    = true)
    {
        if (!$this->ticket_policy->create()) {
            if ($api) {
                return response()->json(['message' => Lang::get('lang.permission_denied')], 403);
            }

            return redirect('dashboard')->with('fails', Lang::get('lang.permission_denied'));
        }

        try {
            $email = null;
            $fullname = null;
            $mobile_number = null;
            $phonecode = null;
            $attach_name = [];
            if ($request->file()) {
                $attach_name = array_keys($request->file());
            }
            $default_values = ['Requester', 'Requester_email', 'Requester_name', 'media_option',
                'Requester_mobile', 'Help_Topic', 'cc', 'Help Topic',
                'Requester_mobile', 'Requester_code', 'Help Topic', 'Assigned', 'Subject',
                'subject', 'priority', 'help_topic', 'body', 'Description', 'Priority',
                'Type', 'Status', 'attachment', 'inline', 'email', 'first_name',
                'last_name', 'mobile', 'country_code', 'api', 'sla', 'dept', 'code', 'source',
                'user_id', 'media_attachment', 'requester', 'status', 'assigned', 'description', 'type', 'media_option', 'Department', 'department', ];
            $default_values = array_merge($default_values, $attach_name);
            $form_data = $request->except($default_values);
            $requester = $request->input('requester');
            $user = null;
            if ($request->has('requester')) {
                $user = User::find($requester);
            }

            if ($request->has('api')) {
                $api = $request->input('api');
            }

            if ($request->has('requester_email')) {
                $email = $request->input('requester_email');
            } elseif ($request->has('email')) {
                $email = $request->input('email');
            } elseif ($user) {
                $email = $user->email;
            }

            if ($request->has('requester_name')) {
                $fullname = $request->input('requester_name');
            } elseif ($request->has('first_name')) {
                $fullname = $request->input('first_name').' '.$request->input('last_name');
            } elseif ($request->has('full_name')) {
                $fullname = $request->input('full_name');
            } elseif ($user) {
                $fullname = $user->first_name;
            }

            if ($request->has('requester_mobile')) {
                $mobile_number = $request->input('requester_mobile');
            } elseif ($request->has('mobile')) {
                $mobile_number = $request->input('mobile');
            } elseif ($user != null) {
                $mobile_number = $user->mobile;
            } else {
                $mobile_number = null;
            }
            if ($request->has('requester_code')) {
                $phonecode = $request->input('requester_code');
            } elseif ($request->has('code')) {
                $phonecode = $request->input('code');
            } elseif ($user != null) {
                $phonecode = $user->country_code;
            } else {
                $phonecode = 0;
            }

            if ($request->has('Help_Topic')) {
                $helptopic = $request->input('Help_Topic');
                $help = Help_topic::where('id', '=', $helptopic)->first();
            } elseif ($request->has('help_topic')) {
                $helptopic = $request->input('help_topic');
                $help = Help_topic::where('id', '=', $helptopic)->first();
            } else {
                $help = Help_topic::first();
                $helptopic = $help->id;
            }
            if ($request->has('Assigned')) {
                $assignto = $request->input('Assigned');
            } elseif ($request->has('assigned')) {
                $assignto = $request->input('assigned');
            } else {
                $assignto = null;
            }
            if ($request->has('subject')) {
                $subject = $request->input('subject');
            } elseif ($request->has('subject')) {
                $subject = $request->input('subject');
            } else {
                $subject = null;
            }

            if ($request->has('description')) {
                $body = $request->input('description');
            } elseif ($request->has('body')) {
                $body = $request->input('body');
            } else {
                $body = null;
            }

            if ($request->has('Priority')) {
                $priority = $request->input('Priority');
            } elseif ($request->has('priority')) {
                $priority = $request->input('priority');
            } else {
                $priority = null;
            }

            if ($request->input('type')) {
                $type = $request->input('type');
            } else {
                $default_type = Tickettype::where('is_default', '>', 0)->select('id')->first();
                $type = $default_type->id;
            }

            if ($request->input('status')) {
                $status = $request->input('status');
            } else {
                $status = null;
            }

            $phone = '';
            if ($request->has('phone')) {
                $phone = $request->input('phone');
            }
            if ($request->has('source')) {
                $source_id = $request->input('source');
            } else {
                $source = Ticket_source::where('name', '=', 'agent')->first();
                $source_id = $source->id;
            }
            $headers = null;
            if ($request->has('cc')) {
                $headers = $request->input('cc');
            }
            $company = '';
            if ($request->has('company')) {
                $company = $request->input('company');
            }

            $department = ($request->has('department')) ? $request->input('department')
                        : $help->department;

            $auto_response = 0;
            $sla = '';
            $attach = [];
            $media_attach = [];
            if ($request->has('media_attachment')) {
                $media_attach = $request->input('media_attachment');
            }
            if ($request->file()) {
                $attach = $request->file();
            }
            $attachment = array_merge($attach, $media_attach);
            $inline = $request->input('inline');
            $result = $this->create_user($email, $fullname, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source_id, $headers, $department, $assignto, $form_data, $auto_response, $status, $type, $attachment, $inline, [], $company);
            if ($result[1]) {
                $status = $this->checkUserVerificationStatus();
                if ($status == 1) {
                    if ($api != false) {
                        $ticket = Tickets::where('ticket_number', '=', $result[0])->select('id')->first();

                        return ['ticket_id' => $ticket->id, 'message' => Lang::get('lang.Ticket-created-successfully')];
                    }

                    return Redirect('newticket')->with('success', Lang::get('lang.Ticket-created-successfully'));
                } else {
                    if ($api != false) {
                        return response()->json(['success' => Lang::get('lang.Ticket-created-successfully')]);
                    }

                    return Redirect('newticket')->with('success', Lang::get('lang.Ticket-created-successfully2'));
                }
            } else {
                if ($api != false) {
                    return response()->json(['error' => Lang::get('lang.failed-to-create-user-tcket-as-mobile-has-been-taken')], 500);
                }

                return Redirect('newticket')->with('fails', Lang::get('lang.failed-to-create-user-tcket-as-mobile-has-been-taken'))->withInput($request->except('password'));
            }
        } catch (Exception $e) {
            $api = true;
            if ($api) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return Redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Shows the ticket thread details.
     *
     * @param type $id
     *
     * @return type response
     */
    public function thread($id)
    {
        $tickets = Tickets::where('tickets.id', $id)
                ->select('tickets.id', 'ticket_number', 'tickets.user_id', 'tickets.assigned_to', 'source', 'dept_id', 'priority_id', 'sla', 'help_topic_id', 'status', 'tickets.created_at', 'tickets.duedate');
        if (!$tickets->first()) {
            return redirect()->back()->with('fails', \Lang::get('lang.invalid_attempt'));
        }
        $auth_agent = \Auth::user();
        $ticket_policy = new \App\Policies\TicketPolicy();
        if ($auth_agent->role == 'agent') {
            $dept = Department::where('id', '=', $auth_agent->primary_dpt)->first();
            $tickets = Tickets::where('id', '=', $id)->first();
            if ($tickets->dept_id == $dept->id) {
                $tickets = $tickets;
            } elseif ($tickets->assigned_to == $auth_agent->id) {
                $tickets = $tickets;
            } else {
                $tickets = null;
            }
//            $tickets = $tickets->where('dept_id', '=', $dept->id)->orWhere('assigned_to', Auth::user()->id)->first();
//            dd($tickets);
        } elseif ($auth_agent->role == 'admin') {
            $tickets = Tickets::where('id', '=', $id)->first();
        } elseif ($auth_agent->role == 'user') {
            $thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
            $ticket_id = \Crypt::encrypt($id);

            return redirect()->route('check_ticket', compact('ticket_id'));
        }
        if ($tickets == null) {
            return redirect()->route('inbox.ticket')->with('fails', \Lang::get('lang.invalid_attempt'));
        }
        $avg = DB::table('ticket_thread')->where('ticket_id', '=', $id)->where('reply_rating', '!=', 0)->avg('reply_rating');
        $avg_rate = explode('.', $avg);
        $avg_rating = $avg_rate[0];
        $thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
        $fileupload = new FileuploadController();
        $fileupload = $fileupload->file_upload_max_size();
        $max_size_in_bytes = $fileupload[0];
        $max_size_in_actual = $fileupload[1];
        $tickets_approval = Tickets::where('id', '=', $id)->first();

        return view('themes.default1.agent.helpdesk.ticket.timeline', compact('tickets', 'max_size_in_bytes', 'max_size_in_actual', 'tickets_approval'), compact('thread', 'avg_rating', 'ticket_policy'));
    }

    public function size()
    {
        $files = Input::file('attachment');
        if (!$files) {
            throw new \Exception('file size exceeded');
        }
        $size = 0;
        if (count($files) > 0) {
            foreach ($files as $file) {
                $size += $file->getSize();
            }
        }

        return $size;
    }

    public function error($e, $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $error = $e->getMessage();
            if (is_object($error)) {
                $error = $error->toArray();
            }

            return response()->json(compact('error'));
            //return $message;
        }
    }

    /**
     * Replying a ticket.
     *
     * @param type Ticket_Thread $thread
     * @param type TicketRequest $request
     *
     * @return type bool
     */
    public function reply(Request $request, $ticketid = '', $mail = true, $system_reply
    = true, $user_id = '', $api = true)
    {
        if (\Input::get('billable')) {
            $this->validate($request, [

                'hours' => ['required', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-9]|0[0-9][0-9]|1[0-9][0-9]|2[0-9][0-9]):[0-5][0-9]$/'],
            ]);
        }
        $this->validate($request, [
            'content' => 'required',
                ], [
            'content.required' => 'Reply Content Required',
        ]);

        try {
            if (!$ticketid) {
                $ticketid = $request->input('ticket_id');
            }
            $body = $request->input('content');
            $email = $request->input('email');
            $inline = $request->input('inline');
            $attachment = $request->input('attachment');
            $source = source($ticketid);
            $form_data = $request->except('content', 'ticket_id', 'attachment', 'inline');
            //\Event::fire(new \App\Events\ClientTicketFormPost($form_data, $email, $source));
            if (!$request->has('do-not-send')) {
                \Event::fire('Reply-Ticket', [['ticket_id' => $ticketid, 'body' => $body]]);
            }
            if ($system_reply == true && Auth::user()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = requester($ticketid);
                if ($user_id !== '') {
                    $user_id = $user_id;
                }
            }

            $thread = $this->saveReply($ticketid, $body, $user_id, $system_reply, $attachment, $inline, $mail);
            if (!$api) {
                return $thread;
            }
            if (\Input::get('billable')) {
                $bill = new Bill();
                $bill->level = 'thread';
                $bill->model_id = $request->input('ticket_id');
                $bill->agent = Auth::user()->id;
                $bill->ticket_id = $request->input('ticket_id');
                $bill->hours = \Input::get('hours');
                $bill->billable = \Input::get('billable');
                $bill->amount_hourly = \Input::get('amount_hourly');
                $bill->note = $body;
                $bill->save();
            }
        } catch (\Exception $e) {
            $result = $e->getMessage();

            return response()->json(compact('result'), 500);
        }
        $result = ['success' => 'Replyed successfully'];

        return response()->json(compact('result'));
    }

    public function saveReply($ticket_id, $body, $user_id, $system_reply, $attachment
    = [], $inline = [], $mail = true, $poster = 'support', $email_content = [])
    {
        $user = User::where('id', $user_id)->select('id', 'role')->first();
        $ticket = $this->saveReplyTicket($ticket_id, $system_reply, $user);
        $thread = $ticket->thread()->create([
            'ticket_id' => $ticket_id,
            'user_id'   => $user_id,
            'poster'    => $poster,
            'body'      => $body,
        ]);
        $this->saveEmailThread($thread, $email_content);
        $this->saveReplyAttachment($thread, $attachment, $inline);
        $this->replyNotification($ticket, $thread, $mail);

        return $thread;
    }

    public function saveReplyTicket($ticket_id, $system_reply)
    {
        $tickets = new Tickets();
        $ticket = $tickets->find($ticket_id);
        if (!$ticket) {
            throw new Exception('Invalid ticket number');
        }

        $ticket->isanswered = '1';
        $ticket->save();
        if ($system_reply == true) {
            if ($ticket->assigned_to == 0) {
                $ticket->assigned_to = Auth::user()->id;
                $ticket->save();
                $data = [
                    'id' => $ticket_id,
                ];
                \Event::fire('ticket-assignment', [$data]);
            }
            if ($ticket->statuses->name !== 'Open') {
                $this->open($ticket_id, $tickets);
            }
        }

        return $ticket;
    }

    public function replyNotification($ticket, $thread, $mail)
    {
        $request = new Request();
        $reply_content = $request->input('content');
        $ticketid = $ticket->id;
        $ticket_subject = title($ticketid);
        $client_name = '';
        $client_email = '';
        $client_contact = '';
        $agent_email = '';
        $agent_name = '';
        $agent_contact = '';
        $requester = $ticket->user;
        $email = $requester->email;
        $assign_agent = $ticket->assigned;
        if ($requester) {
            $client_name = ($requester->first_name != '' || $requester->last_name
                    != null) ? $requester->first_name.' '.$requester->last_name
                        : $requester->user_name;
            $client_email = $requester->email;
            $client_contact = $requester->mobile;
        }
        if ($assign_agent) {
            $agent_email = $assign_agent->email;
            $agent_name = ($assign_agent->first_name != '' || $assign_agent->last_name
                    != null) ? $assign_agent->first_name.' '.$assign_agent->last_name
                        : $assign_agent->user_name;
            $agent_contact = $assign_agent->mobile;
        }
        $ticket_number = $ticket->ticket_number;
        $ticket_link = url('thread', $ticket->id);
        $username = $requester->first_name;
        if (!empty(Auth::user()->agent_sign)) {
            $agentsign = Auth::user()->agent_sign;
        } else {
            $agentsign = ($thread->user->role != 'user') ? $thread->user->agent_sign
                        : null;
        }

        // Event
        \Event::fire(new \App\Events\FaveoAfterReply($reply_content, $requester->mobile, $requester->country_code, $request, $ticket, $thread));

        if (Auth::user()) {
            $u_id = Auth::user()->first_name.' '.Auth::user()->last_name;
        } else {
            $u_id = $this->getAdmin()->first_name.' '.$this->getAdmin()->last_name;
        }
        $data = [
            'ticket_id' => $ticketid,
            'u_id'      => $u_id,
            'body'      => $reply_content,
        ];

        //\Event::fire('Reply-Ticket', array($data));
        $activity_by = ($thread->user->first_name != '' || $thread->user->first_name
                != null) ? $thread->user->first_name.' '.$thread->user->last_name
                    : $thread->user->user_name;

        if (Auth::user() && (Auth::user()->id == $ticket->assigned_to)) {
            $activity_by = 'you';
        }

        $line = ''; //"---Reply above this line---<br><br>";
        $collaborators = Ticket_Collaborator::where('ticket_id', '=', $ticketid)->get();
        if (!$email) {
            $mail = false;
        }
        if ($thread->user->role == 'user') {
            $key = 'reply_notification_alert';
            $scenario = 'ticket-reply-agent';
        } else {
            $key = 'reply_alert';
            $scenario = 'ticket-reply';
        }
        $message = str_replace('Â', '', utfEncoding($line.$thread->purify(false)));
        $ticket_due_date = '';
        $ticket_created_date = '';
        if ($ticket->duedate) {
            $ticket_due_date = $ticket->duedate->tz(timezone());
        }
        if ($ticket->created_at) {
            $ticket_created_date = $ticket->created_at->tz(timezone());
        }
        $notifications[] = [
            $key => [
                'from'      => $this->PhpMailController->mailfrom('1', $ticket->dept_id),
                'message'   => ['subject'     => $ticket_subject.'[#'.$ticket_number.']',
                    'body'                    => $message,
                    'scenario'                => $scenario,
                    'attachments'             => $thread->attach()->get()->toArray(),
                ],
                'variable'  => [
                    'ticket_subject'       => title($ticket->id),
                    'ticket_number'        => $ticket_number,
                    'ticket_link'          => $ticket_link,
                    'ticket_due_date'      => $ticket_due_date,
                    'ticket_created_at'    => $ticket_created_date,
                    'client_name'          => $client_name,
                    'client_email'         => $client_email,
                    'client_contact'       => $client_contact,
                    'agent_email'          => $agent_email,
                    'agent_name'           => $agent_name,
                    'agent_contact'        => $agent_contact,
                    'agent_sign'           => $agentsign,
                    'activity_by'          => $activity_by,
                    'department_signature' => $this->getDepartmentSign($ticket->dept_id),
                ],
                'ticketid'  => $ticket->id,
                'send_mail' => $mail,
                'model'     => $thread,
                'thread'    => $thread,
            ],
        ];
        $notification = new Notifications\NotificationController();
        $notification->setDetails($notifications);
    }

    /**
     * Ticket edit and save ticket data.
     *
     * @param type               $ticket_id
     * @param type Ticket_Thread $thread
     *
     * @return type bool
     */
    public function ticketEditPost($ticket_id, Ticket_Thread $thread, Tickets $tickets, Request $request)
    {
        if (!$this->ticket_policy->edit()) {
            $response = ['message' => Lang::get('lang.permission_denied')];

            return response()->json(compact('response'), 403);
        }
        $this->validate($request, [
            'subject'         => 'required',
            'help_topic'      => 'required',
            'ticket_source'   => 'required',
            'ticket_priority' => 'required',
            //'ticket_type'     => 'required',
        ]);

        try {
            $ticket = $tickets->where('id', '=', $ticket_id)->first();
            $tkt_dept = $ticket->dept_id;
            // dd($tkt_dept->dept_id);
            $priority = Input::get('ticket_priority');
            if ($request->has('assigned')) {
                $ticket->assigned_to = Input::get('assigned');
            }
            $ticket->help_topic_id = Input::get('help_topic');
            // $dept = Help_topic::select('department')->where('id', '=', $ticket->help_topic_id)->first();
            // $dept = $tkt_dept->dept_id;

            $priority_id = $priority; //$this->getPriority($priority, $sla);
            $ticket->source = Input::get('ticket_source');
            $ticket->priority_id = $priority_id;
            //$ticket->type          = Input::get('ticket_type');
            $ticket->dept_id = $tkt_dept;
            //$ticket = $this->updateOverdue($ticket, $sla);
            $ticket->save();
            $threads = $thread->where('ticket_id', '=', $ticket_id)->first();
            $threads->title = Input::get('subject');
            $threads->save();
            \Event::fire('notification', [$threads]);
        } catch (\Exception $ex) {
            $result = $ex->getMessage();

            return response()->json(compact('result'), 500);
        }
        $result = ['success' => 'Edited successfully'];

        return response()->json(compact('result'));
    }

    /**
     * Print Ticket Details.
     *
     * @param type $id
     *
     * @return type respponse
     */
    public function ticket_print($id)
    {
        $tickets = Tickets::
                leftJoin('ticket_thread', function ($join) {
                    $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                    ->whereNotNull('ticket_thread.title');
                })
                ->leftJoin('department', 'tickets.dept_id', '=', 'department.id')
                ->leftJoin('help_topic', 'tickets.help_topic_id', '=', 'help_topic.id')
                ->where('tickets.id', '=', $id)
                ->select('ticket_thread.title', 'tickets.ticket_number', 'department.name as department', 'help_topic.topic as helptopic')
                ->first();
        $ticket = Tickets::where('tickets.id', '=', $id)->first();
        $html = view('themes.default1.agent.helpdesk.ticket.pdf', compact('id', 'ticket', 'tickets'))->render();
        $html1 = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        return PDF::load($html1)->show();
    }

    /**
     * Generates Ticket Number.
     *
     * @param type $ticket_number
     *
     * @return type integer
     */
    public function ticketNumberold($ticket_number)
    {
        $number = $ticket_number;
        $number = explode('-', $number);
        $number1 = $number[0];
        if ($number1 == 'ZZZZ') {
            $number1 = 'AAAA';
        }
        $number2 = $number[1];
        if ($number2 == '9999') {
            $number2 = '0000';
        }
        $number3 = $number[2];
        if ($number3 == '9999999') {
            $number3 = '0000000';
        }
        $number1++;
        $number2++;
        $number3++;
        $number2 = sprintf('%04s', $number2);
        $number3 = sprintf('%07s', $number3);
        $array = [$number1, $number2, $number3];
        $number = implode('-', $array);

        return $number;
    }

    public function ticketNumber($ticket_number)
    {
        $ticket_settings = new \App\Model\helpdesk\Settings\Ticket();
        $setting = $ticket_settings->find(1);
        $format = $setting->num_format;
        $type = $setting->num_sequence;
        $number = $this->getNumber($ticket_number, $type, $format);

        return $number;
    }

    public function getNumber($ticket_number, $type, $format, $check = true)
    {
        $force = false;
        if ($check === false) {
            $force = true;
        }
        $controller = new \App\Http\Controllers\Admin\helpdesk\SettingsController();
        if ($ticket_number) {
            $number = $controller->nthTicketNumber($ticket_number, $type, $format, $force);
        } else {
            $number = $controller->switchNumber($format, $type);
        }
        $number = $this->generateTicketIfExist($number, $type, $format);

        return $number;
    }

    public function generateTicketIfExist($number, $type, $format)
    {
        $tickets = new Tickets();
        $ticket = $tickets->where('ticket_number', $number)->first();
        if ($ticket) {
            $number = $this->getNumber($number, $type, $format, false);
        }

        return $number;
    }

    /**
     * check email for dublicate entry.
     *
     * @param type $email
     *
     * @return type bool
     */
    public function checkEmail($email)
    {
        $check = User::where('email', '=', $email)->orWhere('user_name', $email)->orWhere('mobile', $email)->first();
        if ($check == true) {
            return $check;
        }

        return false;
    }

    /**
     * @category fucntion to check if mobile number is unqique or not
     *
     * @param string $mobile
     *
     * @return bool true(if mobile exists in users table)/false (if mobile does not exist in user table)
     */
    public function checkMobile($mobile)
    {
        $check = User::where('mobile', '=', $mobile)->first();
        if (count($check) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Create User while creating ticket.
     *
     * @param type $emailadd
     * @param type $username
     * @param type $subject
     * @param type $phone
     * @param type $helptopic
     * @param type $sla
     * @param type $priority
     * @param type $system
     *
     * @return type bool
     */
    public function create_user($emailadd, $username, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $from_data, $auto_response, $status, $type, $attachment
    = [], $inline = [], $email_content = [], $org = '')
    {
        $email;
        $username;
        $unique = $emailadd;
        if (!$unique) {
            $unique = $mobile_number;
        }
        if (!$unique) {
            $unique = $username;
        }
        // check emails
        $ticket_creator = $username;
        $checkemail = $this->checkEmail($unique, $emailadd);
        $company = $this->company();
        if ($checkemail == false) {
            if ($mobile_number != '' || $mobile_number != null) {
                if (is_numeric($mobile_number)) {
                    $check_mobile = $this->checkMobile($mobile_number);
                    if ($check_mobile == true) {
                        return ['0' => 'not available', '1' => false];
                    }
                }
            }
            // Generate password
            $password = $this->generateRandomString();
            // create user
            $user = new User();
            $user_name_123 = explode(' ', $username);
            $user_first_name = $user_name_123[0];
            if (isset($user_name_123[1])) {
                $user_last_name = $user_name_123[1];
                $user->last_name = $user_last_name;
            }
            $user->first_name = $user_first_name;
            $user_status = $this->checkUserVerificationStatus();
            $user->user_name = $unique;
            if ($emailadd == '') {
                $user->email = null;
            } else {
                $user->email = $emailadd;
            }
            $user->password = Hash::make($password);
            $user->phone_number = $phone;
            $user->country_code = $phonecode;
            if ($mobile_number == '') {
                $user->mobile = null;
            } else {
                $user->mobile = $mobile_number;
            }
            $user->role = 'user';
            $user->active = $user_status;
            $token = str_random(60);
            $user->email_verify = $token;
            $user->mobile_otp_verify = $token;
            // mail user his/her password
            \Event::fire(new \App\Events\ClientTicketFormPost($from_data, $emailadd, $source));
            if ($user->save()) {
                $user_id = $user->id;
                $email_mandatory = CommonSettings::select('status')->where('option_name', '=', 'email_mandatory')->first();
                if ($user_status == 0 || ($email_mandatory->status == 0 || $email_mandatory->status
                        == '0')) {
                    $value = [
                        'full_name' => $username,
                        'email'     => $emailadd,
                        'code'      => $phonecode,
                        'mobile'    => $mobile_number,
                        'user_name' => $unique,
                        'password'  => $password,
                    ];
                    \Event::fire(new \App\Events\LoginEvent($value));
                }
                // Event fire
                \Event::fire(new \App\Events\ReadMailEvent($user_id, $password));
                $notification[] = [
                    'registration_notification_alert' => [
                        'userid'   => $user_id,
                        'from'     => $this->PhpMailController->mailfrom('1', '0'),
                        'message'  => ['subject' => null, 'scenario' => 'registration-notification'],
                        'variable' => ['new_user_name'  => $user->first_name, 'new_user_email' => $emailadd,
                            'user_password'             => $password, ],
                    ],
                    'registration_alert'              => [
                        'userid'   => $user_id,
                        'from'     => $this->PhpMailController->mailfrom('1', '0'),
                        'message'  => ['subject' => null, 'scenario' => 'registration'],
                        'variable' => ['new_user_name'           => $user->first_name, 'new_user_email'          => $emailadd,
                            'account_activation_link'            => faveoUrl('/account/activate/'.$token), ],
                    ],
                    'new_user_alert'                  => [
                        'userid'   => $user_id,
                        'model'    => $user,
                        'from'     => $this->PhpMailController->mailfrom('1', '0'),
                        'message'  => ['subject' => null, 'scenario' => 'new-user'],
                        'variable' => ['new_user_name'     => $user->first_name, 'new_user_email'    => $unique,
                            'user_profile_link'            => faveoUrl('/user/'.$user_id), ],
                    ],
                ];
            }
        } else {
            $username = $checkemail->first_name;
            $user_id = $checkemail->id;
        }

        $ticket_number = $this->check_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $from_data, $status, $type, $attachment, $inline, $email_content, $org);
        $ticket_number2 = $ticket_number[0];
        $ticketdata = Tickets::where('ticket_number', '=', $ticket_number2)->first();
        $assigner = '';
        if (Auth::user()) {
            $assigner = Auth::user()->first_name.' '.Auth::user()->last_name;
            $agentsign = Auth::user()->agent_sign;
        } elseif ($ticketdata->assigned) {
            $assigner = $ticketdata->assigned->first_name.' '.$ticketdata->assigned->last_name;
            $agentsign = $ticketdata->assigned->agent_sign;
        }
        $due_date = '';
        $created_at = '';
        if ($ticketdata->duedate) {
            $due_date = $ticketdata->duedate->tz(timezone());
        }
        if ($ticketdata->created_at) {
            $created_at = $ticketdata->created_at->tz(timezone());
        }

        $client_detail = User::where('id', '=', $ticketdata->user_id)->first();
        $client_name = ($client_detail->first_name != '' || $client_detail->first_name
                != null) ? $client_detail->first_name.' '.$client_detail->last_name
                    : $client_detail->user_name;
        $client_email = $client_detail->email;
        $client_contact = $client_detail->mobile;

        if ($ticketdata->assigned_to) {
            $agent_detail = User::where('id', '=', $ticketdata->assigned_to)->first();
            $assignee_name = ($agent_detail->first_name != '' || $agent_detail->first_name
                    != null) ? $agent_detail->first_name.' '.$agent_detail->last_name
                        : $agent_detail->user_name;
            $assignee_email = $agent_detail->email;
            $assignee_contact = $agent_detail->mobile;

            $notification[] = [
                'ticket_assign_alert' => [
                    'ticketid' => $ticketdata->id,
                    'from'     => $this->PhpMailController->mailfrom('1', $ticketdata->dept_id),
                    'message'  => ['subject'  => 'Assign ticket '.'[#'.$ticketdata->ticket_number.']',
                        'scenario'            => 'assign-ticket', ],
                    'variable' => [
                        'ticket_subject'       => title($ticketdata->id),
                        'ticket_number'        => $ticketdata->ticket_number,
                        'activity_by'          => $assigner,
                        'ticket_due_date'      => $due_date,
                        'ticket_created_at'    => $created_at,
                        'ticket_link'          => faveoUrl('/thread/'.$ticketdata->id),
                        'agent_name'           => $assignee_name,
                        'agent_email'          => $assignee_email,
                        'agent_contact'        => $assignee_contact,
                        'client_name'          => $client_name,
                        'client_email'         => $client_email,
                        'client_contact'       => $client_contact,
                        'agent_sign'           => $agentsign,
                        'department_signature' => $this->getDepartmentSign($ticketdata->dept_id),
                    ],
                    'model'    => $ticketdata,
                ],
            ];
        }

        if ($ticketdata->team_to) {
            $team_detail = Teams::where('id', '=', $ticketdata->team_id)->first();
            $assignee = $team_detail->name;
            $notification[] = [
                'ticket_assign_alert' => [
                    'ticketid' => $ticketdata->id,
                    'from'     => $this->PhpMailController->mailfrom('1', $ticketdata->dept_id),
                    'message'  => ['subject'  => 'Assign ticket '.'[#'.$ticketdata->ticket_number.']',
                        'scenario'            => 'team_assign_ticket', ],
                    'variable' => [
                        'ticket_subject'       => title($ticketdata->id),
                        'ticket_number'        => $ticketdata->ticket_number,
                        'activity_by'          => $assigner,
                        'ticket_due_date'      => $due_date,
                        'ticket_created_at'    => $created_at,
                        'ticket_link'          => faveoUrl('/thread/'.$ticketdata->id),
                        'assigned_team_name'   => $assignee,
                        'client_name'          => $client_name,
                        'client_email'         => $client_email,
                        'client_contact'       => $client_contact,
                        'agent_sign'           => $agentsign,
                        'department_signature' => $this->getDepartmentSign($ticketdata->dept_id),
                    ],
                    'model'    => $ticketdata,
                ],
            ];
        }

        $threaddata = Ticket_Thread::where('title', '!=', '')
                        ->where('ticket_id', '=', $ticketdata->id)->first();
        $is_reply = $ticket_number[1];
        //dd($source);
        $system = $this->system();
        $updated_subject = title($ticketdata->id).'[#'.$ticket_number2.']';
        //$body = $threaddata->purify();
        //dd($body);
        if ($ticket_number2) {
            // send ticket create details to user
            if ($is_reply == 0) {
                $mail = 'create-ticket-agent';
                $message = $threaddata->purify(false);
                if (Auth::user()) {
                    $sign = Auth::user()->agent_sign;
                } else {
                    $sign = $company;
                }
            } elseif ($is_reply == 1) {
                $this_thread = Ticket_Thread::where('ticket_id', '=', $ticketdata->id)->where('is_internal', 0)->orderBy('id', 'DESC')->first();
                $mail = 'ticket-reply-agent';
                $message = $this_thread->purify(false);
            }
            $message2 = str_replace('Â', '', utfEncoding($message));
            if ($is_reply != 1) {
                $notification[] = ['new_ticket_alert'              => [
                        'from'     => $this->PhpMailController->mailfrom('0', $ticketdata->dept_id),
                        'message'  => [
                            'subject'  => $updated_subject,
                            'body'     => $message,
                            'scenario' => $mail,
                        ],
                        'variable' => [
                            'client_name'             => $ticket_creator,
                            'client_email'            => $emailadd,
                            'ticket_number'           => $ticket_number2,
                            'system_link'             => url('thread/'.$ticketdata->id),
                            'department_sign'         => $this->getDepartmentSign($ticketdata->dept_id),
                            'ticket_client_edit_link' => faveoUrl('ticket/'.$ticketdata->id.'/details'),
                        //'agent_sign' => Auth::user()->agent_sign,
                        ],
                        'ticketid' => $ticketdata->id,
                        'model'    => $ticketdata,
                        'userid'   => $ticketdata->user_id,
                        'thread'   => $threaddata,
                    ],
                    'new_ticket_confirmation_alert' => [
                        'from'     => $this->PhpMailController->mailfrom('0', $ticketdata->dept_id),
                        'message'  => [
                            'subject'  => $updated_subject,
                            'body'     => $message,
                            'scenario' => 'create-ticket',
                            'cc'       => $headers,
                        ],
                        'variable' => [
                            'client_name'             => $ticket_creator,
                            'client_email'            => $emailadd,
                            'ticket_number'           => $ticket_number2,
                            'system_link'             => url('/'),
                            'department_signature'    => $this->getDepartmentSign($ticketdata->dept_id),
                            'ticket_client_edit_link' => faveoUrl('ticket/'.$ticketdata->id.'/details'),
                        ],
                        'ticketid' => $ticketdata->id,
                        'model'    => $ticketdata,
                        'userid'   => $ticketdata->user_id,
                        'thread'   => $threaddata,
                    ],
                ];

                $data = [
                    'ticket_number' => $ticket_number2,
                    'user_id'       => $user_id,
                    'subject'       => $subject,
                    'body'          => $body,
                    'status'        => $status,
                    'Priority'      => $priority,
                ];
                \Event::fire('Create-Ticket', [$data]);
                $alert = new Notifications\NotificationController();
                $alert->setDetails($notification);
            }
            $data = [
                'id' => $ticketdata->id,
            ];
            \Event::fire('ticket-assignment', [$data]);

            return ['0' => $ticket_number2, '1' => true];
        }
    }

    /**
     * Default helptopic.
     *
     * @return type string
     */
    public function default_helptopic()
    {
        $helptopic = '1';

        return $helptopic;
    }

    /**
     * Default SLA plan.
     *
     * @return type string
     */
    public function default_sla()
    {
        $sla = '1';

        return $sla;
    }

    /**
     * Default Priority.
     *
     * @return type string
     */
    public function default_priority()
    {
        $priority = '1';

        return $prioirty;
    }

    public function checkTicketForEmailReply($subject, $email_content)
    {
        $ticket = null;
        $email_thread = '';
        $read_subject = explode('[#', $subject);
        if (isset($read_subject[1])) {
            $separate = explode(']', $read_subject[1]);
            $number = substr($separate[0], 0, 20);
            $ticket = Tickets::where('ticket_number', '=', $number)->first();
        } elseif (count($email_content) > 0) {
            $reference_id = checkArray('reference_id', $email_content);
            //$msg_id = checkArray('message_id', $email_content);
            if ($reference_id) {
                $email_thread = \App\Model\helpdesk\Ticket\EmailThread::where('message_id', $reference_id)->select('id', 'ticket_id')->first();
            }
            if ($email_thread) {
                $ticket = $email_thread->ticket()->first();
            }
        }

        return $ticket;
    }

    /**
     * Check the response of the ticket.
     *
     * @param type $user_id
     * @param type $subject
     * @param type $body
     * @param type $helptopic
     * @param type $sla
     * @param type $priority
     *
     * @return type string
     */
    public function check_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data, $status, $type, $attachment, $inline
    = [], $email_content = [], $company = '')
    {
        $ticket = $this->checkTicketForEmailReply($subject, $email_content);
        $thread_body = explode('---Reply above this line---', $body);
        $body = $thread_body[0];

        if ($ticket) {
            $id = $ticket->id;

            $ticket_number = $ticket->ticket_number;
            if ($ticket->status > 1) {
                $ticket->status = 1;
                $ticket->closed = 0;
                $ticket->closed_at = date('Y-m-d H:i:s');
                $ticket->reopened = 1;
                $ticket->reopened_at = date('Y-m-d H:i:s');
                $ticket->save();

                $ticket_status = Ticket_Status::where('id', '=', 1)->first();

                $user_name = User::where('id', '=', $user_id)->first();
                if ($user_name->role == 'user') {
                    $username = $user_name->user_name;
                } elseif ($user_name->role == 'agent' or $user_name->role == 'admin') {
                    $username = $user_name->first_name.' '.$user_name->last_name;
                }

                // $ticket_threads = new Ticket_Thread();
                // $ticket_threads->ticket_id = $id;
                // $ticket_threads->user_id = $user_id;
                // $ticket_threads->is_internal = 1;
                // $ticket_threads->body = $ticket_status->message . ' ' . $username;
                // $ticket_threads->save();
                // event fire for internal notes
                //event to change status
                $data = [
                    'id'         => $ticket_number,
                    'status'     => 'Open',
                    'first_name' => $username,
                    'last_name'  => '',
                ];
                \Event::fire('change-status', [$data]);
            }
            if (isset($id)) {
                $user = User::where('id', '=', $user_id)->first();
                $poster = 'client';
                if ($user->role != 'user') {
                    $poster = 'support';
                }
                $thread = $this->saveReply($id, $body, $user_id, false, $attachment, $inline, true, $poster, $email_content);
                if ($thread) {
                    \Event::fire('ticket.details', ['ticket' => $thread]);

                    return [$ticket_number, 1];
                }
            }
        } else {
            $ticket_number = $this->createTicket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data, $status, $type, $attachment, $inline, $email_content, $company);

            return [$ticket_number, 0];
        }
    }

    /**
     * Create Ticket.
     *
     * @param type $user_id
     * @param type $subject
     * @param type $body
     * @param type $helptopic
     * @param type $sla
     * @param type $priority
     *
     * @return type string
     */
    public function createTicket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data, $status, $type, $attachment, $inline
    = [], $email_content = [], $company = '', $fork = false)
    {
        $ticket_number = '';
        $max_number = Tickets::whereRaw('id = (select max(`id`) from tickets)')->first();
        if ($max_number) {
            $ticket_number = $max_number->ticket_number;
        }
        $sla = (!$sla) ? defaultSla() : $sla;
        $user_status = User::select('active')->where('id', '=', $user_id)->first();
        $ticket = new Tickets();
        $ticket->ticket_number = $this->ticketNumber($ticket_number);
        $ticket->user_id = $user_id;
        $ticket->dept_id = $dept;
        $ticket->help_topic_id = $helptopic;
        $ticket->sla = $sla;
        $ticket_assign = $assignto;

        $assigned_to = null;
        $team_id = null;
        if (!$ticket_assign || $ticket_assign == ' ') {
            $assigned_to = null;
            $team_id = null;
        } elseif (is_numeric($ticket_assign)) {
            $assigned_to = $ticket_assign;
        } else {
            $assignto = explode('_', $ticket_assign);
            if ($assignto[0] == 'team') {
                $team_id = $assignto[1];
                $assigned_to = null;
            } elseif ($assignto[0] == 'user') {
                $assigned_to = $assignto[1];
                $team_id = null;
            }
            //dd($ticket_assign);
        }

//        if (!$assigned_to) {
//            $assigned_to = \Event::fire('ticket.assign', [['department' => $dept, 'type' => $type, 'extra' => $form_data]])[0];
//        }
        $ticket->team_id = $team_id;
        // dd($ticket->team_id);
        $ticket->assigned_to = $assigned_to;
        $ticket->priority_id = $priority;
        $ticket->type = $type;
        $ticket->source = $source;
        $ticket->status = $this->getStatus($user_id, $status);
        if ($ticket->status == null) {
            $ticket->status = 1;
        }
        $fields = $this->ticketFieldsInArray($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $ticket_assign, $form_data, $ticket->status, $type, $attachment, $inline, $email_content, $company);
        $ticket = event(new \App\Events\WorkFlowEvent(['values' => $fields, 'ticket' => $ticket]))[0];
        $ticket->save();
        $ticket->notify = false;
        if (!\Input::has('duedate')) {
            $sla_plan = Sla_plan::where('id', '=', $sla)->first();
            $ovdate = $ticket->created_at;
            $new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan->grace_period));
            $ticket->duedate = $new_date;
        } else {
            //dd(getCarbon(\Input::get('duedate'),'/','m-d-Y'));
            $ticket->duedate = getCarbon(\Input::get('duedate'), '/', 'm-d-Y'); //\Input::get('duedate');
        }
        $ticket->save();

        if ($fork) {
            return $ticket;
        }

        $create_thread = $this->ticketThread($subject, $body, $ticket->id, $user_id, $attachment, $inline, $email_content);

        //dd($faveotime);
        // assign email send
        if ($team_id != null) {
            $team_detail = Teams::where('id', '=', $ticket->team_id)->first();
            $assignee = $team_detail->name;

            $ticket_number = $ticket->ticket_number;
            $thread = new Ticket_Thread();
            $thread->ticket_id = $ticket->id;
            $thread->user_id = Auth::user()->id;
            $thread->is_internal = 1;
            $thread->body = 'This Ticket has been assigned to '.$assignee;
            $thread->save();
        }
        if ($ticket->assigned_to) {
            $id = $assigned_to;
            $user_detail = User::where('id', '=', $ticket->assigned_to)->first();
            $assignee = $user_detail->first_name.' '.$user_detail->last_name;

            $thread = new Ticket_Thread();
            $thread->ticket_id = $ticket->id;
            $thread->user_id = $user_detail->id;
            $thread->is_internal = 1;
            $thread->body = 'This Ticket has been assigned to '.$assignee;
            $thread->save();

            $ticket_number = $ticket->ticket_number;
            $data = [
                'id' => $ticket->id,
            ];
            \Event::fire('ticket-assignment', [$data]);
        }

        \Event::fire('after.ticket.created', $ticket);

        $ticket_number = $ticket->ticket_number;
        $id = $ticket->id;
        $this->customFormCreate($form_data, $id);

        // store collaborators
        $this->storeCollaborators($headers, $id);
        if ($create_thread == true) {
            return $ticket_number;
        }
    }

    public function customFormCreate($form_data, $id)
    {
        if (is_array($form_data) && count($form_data) > 0) {
            foreach ($form_data as $key => $data) {
                if (!is_string($key)) {
                    $this->customFormCreate($data, $id);
                } else {
                    if (!$this->checkDefaultValues($key)) {
                        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                        $form = Ticket_Form_Data::updateOrCreate([
                                    'ticket_id' => $id,
                                    'key'       => $key,
                                        ], [
                                    'title'   => '',
                                    'content' => '',
                        ]);
                        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                        $this->customChildFormCreate($data, $id, $key, $form->id);
                    }
                }
            }
        }
    }

    public function customChildFormCreate($form_data, $id, $parent_key = '', $parent_form_id
    = '')
    {
        if (is_array($form_data) && count($form_data) > 0) {
            foreach ($form_data as $key => $data) {
                //echo json_encode($data) . "<br>";
                if (!is_string($key) && is_array($data)) {
                    $this->customFormCreate($data, $id);
                } else {
                    //echo $parent_key . "<br>";
                    //echo "child key=>" . $key . "\026\n";

                    if (!$this->checkDefaultValues($parent_key)) {
                        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                        Ticket_Form_Data::updateOrCreate([
                            'ticket_id' => $id,
                            'key'       => $parent_key,
                                ], [
                            'title'   => $parent_form_id,
                            'content' => $key,
                        ]);
                    }
                    \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                    $this->customFormCreate($data, $id);
                }
            }
        } else {
            //echo $parent_key . "<br>";
            if (!$this->checkDefaultValues($parent_key)) {
                Ticket_Form_Data::updateOrCreate([
                    'ticket_id' => $id,
                    'key'       => $parent_key,
                        ], [
                    'title'   => $parent_form_id,
                    'content' => $form_data,
                ]);
            }
        }
    }

    public function checkDefaultValues($key)
    {
        $check = false;
        $default = ['Requester', 'Requester_email', 'Requester_name', 'Requester_mobile',
            'Help Topic',
            'Requester_mobile', 'Requester_code', 'Help_Topic', 'Assigned', 'Subject',
            'Description',
            'Priority', 'Type', 'Status', 'attachment', 'inline', 'email', 'first_name',
            'last_name', 'mobile', 'country_code', 'api', ];
        if (in_array($key, $default)) {
            $check = true;
        }

        return $check;
    }

    public function ticketFieldsInArray($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data, $status, $type, $attachment, $inline, $email_content, $company
    = '')
    {
        $user = User::where('id', $user_id)->select('id', 'email', 'first_name', 'country_code', 'phone_number', 'mobile')->first();
        $fromaddress = $fromname = $phone = $phonecode = $mobile_number
                = $org_name = '';
        if ($user) {
            $fromaddress = $user->email;
            $fromname = $user->first_name;
            $phone = $user->phone_number;
            $phonecode = $user->country_code;
            $mobile_number = $user->mobile;
            if ($company) {
                $org = \App\Model\helpdesk\Agent_panel\Organization::select('name')->whereId($company)->first();
                if ($org) {
                    $org_name = $org->name;
                }
            } elseif ($user->org && $user->org->organisation) {
                $org_name = $user->org->organisation->name;
            }
        }

        return [
            'email'         => $fromaddress,
            'name'          => $fromname,
            'subject'       => $subject,
            'body'          => $body,
            'phone'         => $phone,
            'code'          => $phonecode,
            'mobile'        => $mobile_number,
            'helptopic'     => $helptopic,
            'sla'           => $sla,
            'priority'      => $priority,
            'source'        => $source,
            'cc'            => $headers,
            'department'    => $dept,
            'agent'         => $assignto,
            //'team' => $team_assign,
            'status'        => $status,
            'custom_data'   => $form_data,
            //'auto_response' => $auto_response,
            'type'          => $type,
            'attachment'    => $attachment,
            'inline'        => $inline,
            'email_content' => $email_content,
            'organization'  => $org_name,
        ];
    }

    public function getStatus($requester_id, $status = '')
    {
        if (!$status) {
            $requester = User::where('id', $requester_id)->first();
            $statuses = new Ticket_Status();
            $name = 'open';
            if ($requester->isDeleted() || $requester->isBan()) {
                $name = 'spam';
            }
            $ticket_status = $statuses->where('state', $name)->first();
            if (!$ticket_status) {
                $ticket_status = $statuses->first();
            }
            $status = $ticket_status->id;
        }

        return $status;
    }

    /**
     * Generate Ticket Thread.
     *
     * @param type $subject
     * @param type $body
     * @param type $id
     * @param type $user_id
     *
     * @return type
     */
    public function ticketThread($subject, $body, $id, $user_id, $attachment, $inline
    = [], $email_content = [])
    {
        //dd('ticketThread',$attachment);
        $thread = new Ticket_Thread();
        $thread->user_id = $user_id;
        $thread->ticket_id = $id;
        $thread->poster = 'client';
        $thread->title = $subject;
        $thread->body = $body;
        if ($thread->save()) {
            $this->saveEmailThread($thread, $email_content);
            if ($attachment || $inline) {
                $this->updateThread($thread, $attachment, $inline);
            }
            \Event::fire('ticket.details', ['ticket' => $thread]); //get the ticket details
            return true;
        }
    }

    public function updateThread($thread, $attachments, $inline = [])
    {
        if (file_exists(app_path('/FaveoStorage/Controllers/StorageController.php'))) {
            try {
                $storage = new \App\FaveoStorage\Controllers\StorageController();

                return $storage->saveAttachments($thread->id, $attachments, $inline);
            } catch (\Exception $ex) {
                loging('attachment', $ex->getMessage());
            }
        } else {
            loging('attachment', 'FaveoStorage not installed');
        }
    }

    public function saveEmailThread($thread, $content)
    {
        $ticket_id = $thread->ticket_id;
        if (is_array($content) && count($content) > 0) {
            $thread->emailThread()->create([
                'ticket_id'      => $ticket_id,
                'message_id'     => checkArray('message_id', $content),
                'uid'            => checkArray('uid', $content),
                'reference_id'   => checkArray('reference_id', $content),
                'fetching_email' => checkArray('fetching_email', $content),
            ]);
        }
    }

    public function saveReplyAttachment($thread, $attachments, $inlines)
    {
        //dd($attachments);
        $drive = storageDrive();
        $thread_id = $thread->id;
        $attach = $thread->attach();
        if ($attachments && count($attachments) > 0) {
            foreach ($attachments as $key => $attachment) {
                if ($key && is_array($attachment)) {
                    foreach ($attachment as $a) {
                        $this->createAttachments($attach, $key, $a, $thread, $drive);
                    }
                } else {
                    $this->createAttachments($attach, $key, $attachment, $thread, $drive);
                }
            }
        }
        if ($inlines && count($inlines) > 0) {
            foreach ($inlines as $inline) {
                $attach->create([
                    'thread_id' => $thread_id,
                    'name'      => $inline['filename'],
                    'size'      => $inline['size'],
                    'type'      => $inline['type'],
                    'poster'    => 'INLINE',
                    'path'      => $inline['path'],
                    'driver'    => $drive,
                ]);
            }
        }

        return $thread;
    }

    public function createAttachments($attach, $key, $attachment, $thread, $drive)
    {
        $thread_id = $thread->id;
        if (is_object($attachment)) {
            $storage = new \App\FaveoStorage\Controllers\StorageController();
            $thread = $storage->saveObjectAttachments($thread->id, $attachment);
        }
        if (is_array($attachment)) {
            $attach->create([
                'thread_id' => $thread_id,
                'name'      => $attachment['filename'],
                'size'      => $attachment['size'],
                'type'      => $attachment['type'],
                'poster'    => 'ATTACHMENT',
                'path'      => $attachment['path'],
                'driver'    => $drive,
            ]);
        }
    }

    /**
     * Generate a random string for password.
     *
     * @param type $length
     *
     * @return type string
     */
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * function to Ticket Close.
     *
     * @param type         $id
     * @param type Tickets $ticket
     *
     * @return type string
     */
    public function close($id, Tickets $ticket, $api = true)
    {
        if (!$this->ticket_policy->close()) {
            if ($api) {
                return response()->json(['message' => 'permission denied'], 403);
            }

            return redirect('dashboard')->with('fails', 'Permission denied');
        }
        $ticket = Tickets::where('id', '=', $id)->first();
        if (Auth::user()->role == 'user') {
            $ticket_status = $ticket->where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();
        } else {
            $ticket_status = $ticket->where('id', '=', $id)->first();
        }
        // checking for unautherised access attempt on other than owner ticket id
        if ($ticket_status == null) {
            return redirect()->route('unauth');
        }
        $ticket_status->status = 3;
        $ticket_status->closed = 1;
        $ticket_status->closed_at = date('Y-m-d H:i:s');
        $ticket_status->save();
        $ticket_thread = Ticket_Thread::where('ticket_id', '=', $ticket_status->id)->first();
        $ticket_subject = $ticket_thread->title;
        $ticket_status_message = Ticket_Status::where('id', '=', $ticket_status->status)->first();
        $thread = new Ticket_Thread();
        $thread->ticket_id = $ticket_status->id;
        $thread->user_id = Auth::user()->id;
        $thread->is_internal = 1;
        $thread->body = $ticket_status_message->message.' '.Auth::user()->first_name.' '.Auth::user()->last_name;
        $thread->save();

        $user_id = $ticket_status->user_id;
        $user = User::where('id', '=', $user_id)->first();
        $email = $user->email;
        $user_name = $user->user_name;
        $ticket_number = $ticket_status->ticket_number;

        $system_from = $this->company();
        $sending_emails = Emails::where('department', '=', $ticket_status->dept_id)->first();
        if ($sending_emails == null) {
            $from_email = $this->system_mail();
        } else {
            $from_email = $sending_emails->id;
        }

        try {
            $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticket_status->dept_id), $to
                    = ['name' => $user_name, 'email' => $email], $message = ['subject' => $ticket_subject.'[#'.$ticket_number.']', 'scenario' => 'close-ticket'], $template_variables
                    = ['ticket_number' => $ticket_number]);
        } catch (\Exception $e) {
            return 0;
        }
        $data = [
            'id'         => $ticket_status->ticket_number,
            'status'     => 'Closed',
            'first_name' => Auth::user()->first_name,
            'last_name'  => Auth::user()->last_name,
        ];
        \Event::fire('change-status', [$data]);

        return 'your ticket'.$ticket_status->ticket_number.' has been closed';
    }

    /**
     * function to Ticket resolved.
     *
     * @param type         $id
     * @param type Tickets $ticket
     *
     * @return type string
     */
    public function resolve($id, Tickets $ticket, $api = true)
    {
        if (!$this->ticket_policy->close()) {
            if ($api) {
                return response()->json(['message' => 'permission denied'], 403);
            }

            return redirect('dashboard')->with('fails', 'Permission denied');
        }
        if (Auth::user()->role == 'user') {
            $ticket_status = $ticket->where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();
        } else {
            $ticket_status = $ticket->where('id', '=', $id)->first();
        }
        // checking for unautherised access attempt on other than owner ticket id
        if ($ticket_status == null) {
            return redirect()->route('unauth');
        }
//        $ticket_status = $ticket->where('id', '=', $id)->first();
        $ticket_status->status = 2;
        $ticket_status->closed = 1;
        $ticket_status->closed_at = date('Y-m-d H:i:s');
        $ticket_status->save();
        $ticket_status_message = Ticket_Status::where('id', '=', $ticket_status->status)->first();
        $thread = new Ticket_Thread();
        $thread->ticket_id = $ticket_status->id;
        $thread->user_id = Auth::user()->id;
        $thread->is_internal = 1;
        if (Auth::user()->first_name != null) {
            $thread->body = $ticket_status_message->message.' '.Auth::user()->first_name.' '.Auth::user()->last_name;
        } else {
            $thread->body = $ticket_status_message->message.' '.Auth::user()->user_name;
        }
        $thread->save();
        $data = [
            'id'         => $ticket_status->ticket_number,
            'status'     => 'Resolved',
            'first_name' => Auth::user()->first_name,
            'last_name'  => Auth::user()->last_name,
        ];
        \Event::fire('change-status', [$data]);

        return 'your ticket'.$ticket_status->ticket_number.' has been resolved';
    }

    /**
     * function to Open Ticket.
     *
     * @param type         $id
     * @param type Tickets $ticket
     *
     * @return type
     */
    public function open($id, Tickets $ticket)
    {
        if (Auth::user()->role == 'user') {
            $ticket_status = $ticket->where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();
        } else {
            $ticket_status = $ticket->where('id', '=', $id)->first();
        }
        // checking for unautherised access attempt on other than owner ticket id
        if ($ticket_status == null) {
            return redirect()->route('unauth');
        }
        $ticket_status->status = 1;
        $ticket_status->reopened_at = date('Y-m-d H:i:s');
        $ticket_status->save();
        $ticket_status_message = Ticket_Status::where('id', '=', $ticket_status->status)->first();
        $thread = new Ticket_Thread();
        $thread->ticket_id = $ticket_status->id;
        $thread->user_id = Auth::user()->id;
        $thread->is_internal = 1;
        $thread->body = $ticket_status_message->message.' '.Auth::user()->first_name.' '.Auth::user()->last_name;
        $thread->save();
        $data = [
            'id'         => $ticket_status->ticket_number,
            'status'     => 'Open',
            'first_name' => Auth::user()->first_name,
            'last_name'  => Auth::user()->last_name,
        ];
        \Event::fire('change-status', [$data]);

        return 'your ticket'.$ticket_status->ticket_number.' has been opened';
    }

    /**
     * Function to delete ticket.
     *
     * @param type         $id
     * @param type Tickets $ticket
     *
     * @return type string
     */
    public function delete($id, Tickets $ticket, $api = true)
    {
        if (!$this->ticket_policy->delete()) {
            if ($api) {
                return response()->json(['message' => 'permission denied'], 403);
            }

            return redirect('dashboard')->with('fails', 'Permission denied');
        }
        $ticket_delete = $ticket->where('id', '=', $id)->first();
        if ($ticket_delete->status == 5) {
            $ticket_delete->delete();
            $ticket_threads = Ticket_Thread::where('ticket_id', '=', $id)->get();
            foreach ($ticket_threads as $ticket_thread) {
                $ticket_thread->delete();
            }
            $ticket_attachments = Ticket_attachments::where('ticket_id', '=', $id)->get();
            foreach ($ticket_attachments as $ticket_attachment) {
                $ticket_attachment->delete();
            }
            $data = [
                'id'         => $ticket_delete->ticket_number,
                'status'     => 'Deleted',
                'first_name' => Auth::user()->first_name,
                'last_name'  => Auth::user()->last_name,
            ];
            \Event::fire('change-status', [$data]);

            return 'your ticket has been delete';
        } else {
            $ticket_delete->is_deleted = 1;
            $ticket_delete->status = 5;
            $ticket_delete->save();
            $ticket_status_message = Ticket_Status::where('id', '=', $ticket_delete->status)->first();
            $thread = new Ticket_Thread();
            $thread->ticket_id = $ticket_delete->id;
            $thread->user_id = Auth::user()->id;
            $thread->is_internal = 1;
            $thread->body = $ticket_status_message->message.' '.Auth::user()->first_name.' '.Auth::user()->last_name;
            $thread->save();
            $data = [
                'id'         => $ticket_delete->ticket_number,
                'status'     => 'Deleted',
                'first_name' => Auth::user()->first_name,
                'last_name'  => Auth::user()->last_name,
            ];
            \Event::fire('change-status', [$data]);

            return 'your ticket'.$ticket_delete->ticket_number.' has been delete';
        }
    }

    /**
     * Function to ban an email.
     *
     * @param type         $id
     * @param type Tickets $ticket
     *
     * @return type string
     */
    public function ban($id, Tickets $ticket, $api = true)
    {
        if (!$this->ticket_policy->ban()) {
            if ($api) {
                return response()->json(['message' => 'permission denied'], 403);
            }

            return redirect('dashboard')->with('fails', 'Permission denied');
        }
        $ticket_ban = $ticket->where('id', '=', $id)->first();
        $ban_email = $ticket_ban->user_id;
        $user = User::where('id', '=', $ban_email)->first();
        $user->ban = 1;
        $user->save();
        $Email = $user->email;

        return 'the user has been banned';
    }

    /**
     * function to assign ticket.
     *
     * @param type $id
     *
     * @return type bool
     */
    public function assign($id, $api = true)
    {
        if (!$this->ticket_policy->assign()) {
            if ($api) {
                return response()->json(['message' => 'permission denied'], 403);
            }

            return redirect('dashboard')->with('fails', 'Permission denied');
        }
        $ticket_array = [];
        if (strpos($id, ',') !== false) {
            $ticket_array = explode(',', $id);
        } else {
            array_push($ticket_array, $id);
        }
        $UserEmail = Input::get('assign_to');
        $assign_to = explode('_', $UserEmail);
        $user_detail = null;
        foreach ($ticket_array as $id) {
            $ticket = Tickets::where('id', '=', $id)->first();
            if ($assign_to[0] == 'team') {
                $ticket->team_id = $assign_to[1];
                $team_detail = Teams::where('id', '=', $assign_to[1])->first();
                $assignee = $team_detail->name;
                $ticket_number = $ticket->ticket_number;
                $ticket->save();
                $ticket_thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
                $ticket_subject = $ticket_thread->title;
                $thread = new Ticket_Thread();
                $thread->ticket_id = $ticket->id;
                $thread->user_id = Auth::user()->id;
                $thread->is_internal = 1;
                $thread->body = 'This Ticket has been assigned to '.$assignee;
                $thread->save();
            } elseif ($assign_to[0] == 'user') {
                $ticket->assigned_to = $assign_to[1];
                if ($user_detail === null) {
                    $user_detail = User::where('id', '=', $assign_to[1])->first();
                    $assignee = $user_detail->first_name.' '.$user_detail->last_name;
                }
                $company = $this->company();
                $system = $this->system();
                $ticket_number = $ticket->ticket_number;
                $ticket->save();
                $data = [
                    'id' => $id,
                ];
                \Event::fire('ticket-assignment', [$data]);
                $ticket_thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
                $ticket_subject = $ticket_thread->title;
                $thread = new Ticket_Thread();
                $thread->ticket_id = $ticket->id;
                $thread->user_id = Auth::user()->id;
                $thread->is_internal = 1;
                $thread->body = 'This Ticket has been assigned to '.$assignee;
                $thread->save();

                $agent = $user_detail->first_name;
                $agent_email = $user_detail->email;
                $ticket_link = route('ticket.thread', $id);
                $master = Auth::user()->first_name.' '.Auth::user()->last_name;

                try {
                    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticket->dept_id), $to
                            = ['name' => $agent, 'email' => $agent_email], $message
                            = ['subject' => $ticket_subject.'[#'.$ticket_number.']', 'scenario' => 'assign-ticket'], $template_variables
                            = ['ticket_agent_name' => $agent, 'ticket_number' => $ticket_number, 'ticket_assigner' => $master, 'ticket_link' => $ticket_link]);
                } catch (\Exception $e) {
                    return 0;
                }
            }
        }

        return 1;
    }

    /**
     * Function to post internal note.
     *
     * @param type $id
     *
     * @return type bool
     */
    public function InternalNote($id)
    {
        //dd($id);
        $InternalContent = Input::get('InternalContent');
        //$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
        $NewThread = new Ticket_Thread();
        $NewThread->ticket_id = $id;
        $NewThread->user_id = Auth::user()->id;
        $NewThread->is_internal = 1;
        $NewThread->thread_type = 'note';
        $NewThread->poster = Auth::user()->role;
        //$NewThread->title = $thread->title;
        $NewThread->body = $InternalContent;
        $NewThread->save();
        $data = [
            'ticket_id' => $id,
            'u_id'      => Auth::user()->first_name.' '.Auth::user()->last_name,
            'body'      => $InternalContent,
        ];
        \Event::fire('Reply-Ticket', [$data]);

        return 1;
    }

    /**
     * Function to surrender a ticket.
     *
     * @param type $id
     *
     * @return type bool
     */
    public function surrender($id)
    {
        $ticket = Tickets::where('id', '=', $id)->first();
        $InternalContent = Auth::user()->first_name.' '.Auth::user()->last_name.' has Surrendered the assigned Ticket';
        $thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
        $NewThread = new Ticket_Thread();
        $NewThread->ticket_id = $thread->ticket_id;
        $NewThread->user_id = Auth::user()->id;
        $NewThread->is_internal = 1;
        $NewThread->poster = Auth::user()->role;
        $NewThread->title = $thread->title;
        $NewThread->body = $InternalContent;
        $NewThread->save();

        $ticket->assigned_to = null;
        $ticket->save();

        return 1;
    }

    /**
     * Search.
     *
     * @param type $keyword
     *
     * @return type array
     */
    public function search($keyword)
    {
        if (isset($keyword)) {
            $data = ['ticket_number' => Tickets::search($keyword)];

            return $data;
        } else {
            return 'no results';
        }
    }

    /**
     * Search.
     *
     * @param type $keyword
     *
     * @return type array
     */
    public function stores($ticket_number)
    {
        $this->layout->header = $ticket_number;
        $content = View::make('themes.default1.admin.tickets.ticketsearch', with(new Tickets()))
                ->with('header', $this->layout->header)
                ->with('ticket_number', \App\Model\Tickets::stores($ticket_number));
        if (Request::header('X-PJAX')) {
            return $content;
        } else {
            $this->layout->content = $content;
        }
    }

    /**
     * store_collaborators.
     *
     * @param type $headers
     *
     * @return type
     */
    public function storeCollaborators($headers, $id)
    {
        $notification = [];
        if (isset($headers)) {
            foreach ($headers as $name => $email) {
                $user = $this->checkEmail($email);
                $user_id = '';
                if (!is_string($name)) {
                    $name = $email;
                }
                if ($user) {
                    if ((int) $user->ban != 1 && (int) $user->is_delete != 1) {
                        $user_id = $user->id;
                    }
                } else {
                    $create_user = new User();
                    $create_user->first_name = $name;
                    $create_user->user_name = $email;
                    $create_user->email = $email;
                    $create_user->active = 1;
                    $create_user->role = 'user';
                    $password = $this->generateRandomString();
                    $create_user->password = Hash::make($password);
                    $token = str_random(60);
                    $create_user->remember_token = $token;
                    $create_user->save();
                    $user_id = $create_user->id;
                    $notification[] = [
                        'registration_notification_alert' => [
                            'userid'   => $user_id,
                            'from'     => $this->PhpMailController->mailfrom('1', '0'),
                            'message'  => ['subject' => null, 'scenario' => 'registration-notification'],
                            'variable' => ['user'          => $create_user->first_name, 'email_address' => $email,
                                'user_password'            => $password, ],
                        ],
                        'registration_alert'              => [
                            'userid'   => $user_id,
                            'from'     => $this->PhpMailController->mailfrom('1', '0'),
                            'message'  => ['subject' => null, 'scenario' => 'registration'],
                            'variable' => ['user'                => $create_user->first_name, 'email_address'       => $email,
                                'password_reset_link'            => faveoUrl('/account/activate/'.$token), ],
                        ],
                        'new_user_alert'                  => [
                            'userid'   => $user_id,
                            'model'    => $create_user,
                            'from'     => $this->PhpMailController->mailfrom('1', '0'),
                            'message'  => ['subject' => null, 'scenario' => 'new-user'],
                            'variable' => ['user'              => $create_user->first_name, 'email_address'     => $email,
                                'user_profile_link'            => faveoUrl('/user/'.$user_id), ],
                        ],
                    ];
                }
                if ($user_id) {
                    $alert = new Notifications\NotificationController();
                    $alert->setDetails($notification);
                    $collaborator_store = new Ticket_Collaborator();
                    $collaborator_store->isactive = 1;
                    $collaborator_store->ticket_id = $id;
                    $collaborator_store->user_id = $user_id;
                    $collaborator_store->role = 'ccc';
                    $collaborator_store->save();
                }
            }
        }

        return true;
    }

    /**
     * company.
     *
     * @return type
     */
    public function company()
    {
        $company = Company::Where('id', '=', '1')->first();
        if ($company->company_name == null) {
            $company = 'Support Center';
        } else {
            $company = $company->company_name;
        }

        return $company;
    }

    /**
     * system.
     *
     * @return type
     */
    public function system()
    {
        $system = System::Where('id', '=', '1')->first();
        if ($system->name == null) {
            $system = 'Support Center';
        } else {
            $system = $system->name;
        }

        return $system;
    }

    /**
     * shows trashed tickets.
     *
     * @return type response
     */
    public function trash()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.trash', compact('table'));
    }

    /**
     * shows unassigned tickets.
     *
     * @return type
     */
    public function unassigned()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.unassigned', compact('table'));
    }

    /**
     * shows tickets assigned to Auth::user().
     *
     * @return type
     */
    public function myticket()
    {
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.ticket.myticket', compact('table'));
    }

    /**
     * cleanMe.
     *
     * @param type $input
     *
     * @return type
     */
    public function cleanMe($input)
    {
        $input = mysqli_real_escape_string($input);
        $input = htmlspecialchars($input, ENT_IGNORE, 'utf-8');
        $input = strip_tags($input);
        $input = stripslashes($input);

        return $input;
    }

    /**
     * autosearch.
     *
     * @param type Image $image
     *
     * @return type json
     */
    public function autosearch($id)
    {
        $term = \Input::get('term');
        $user = \App\User::where('email', 'LIKE', '%'.$term.'%')->pluck('email');
        echo json_encode($user);
    }

    /**
     * autosearch2.
     *
     * @param type Image $image
     *
     * @return type json
     */
    public function autosearch2(User $user)
    {
        $user = $user->pluck('email');
        echo json_encode($user);
    }

    /**
     * autosearch.
     *
     * @param type Image $image
     *
     * @return type json
     */
    public function usersearch()
    {
        $email = Input::get('search');
        $ticket_id = Input::get('ticket_id');
        $data = User::where('email', '=', $email)->first();
        if ($data == null) {
            return '<div id="alert11" class="alert alert-warning alert-dismissable">'
                    .'<button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                    .'<i class="icon fa fa-ban"></i>'
                    .'This Email doesnot exist in the system'
                    .'</div>'
                    .'</div>';
        }
        $ticket_collaborator = Ticket_Collaborator::where('ticket_id', '=', $ticket_id)->where('user_id', '=', $data->id)->first();
        if (!isset($ticket_collaborator)) {
            $ticket_collaborator = new Ticket_Collaborator();
            $ticket_collaborator->isactive = 1;
            $ticket_collaborator->ticket_id = $ticket_id;
            $ticket_collaborator->user_id = $data->id;
            $ticket_collaborator->role = 'ccc';
            $ticket_collaborator->save();

            return '<div id="alert11" class="alert alert-dismissable" style="color:#60B23C;background-color:#F2F2F2;"><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Success!</h4><h4><i class="icon fa fa-user"></i>'.$data->user_name.'</h4><div id="message-success1">'.$data->email.'</div></div>';
        } else {
            return '<div id="alert11" class="alert alert-warning alert-dismissable"><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i>'.$data->user_name.'</h4><div id="message-success1">'.$data->email.'<br/>This user already Collaborated</div></div>';
        }
    }

    /**
     * useradd.
     *
     * @param type Image $image
     *
     * @return type json
     */
    public function useradd()
    {
        $name = Input::get('name');
        $email = Input::get('email');
        $validator = \Validator::make(
                        ['email' => $email, 'name' => $name], ['email' => 'required|email']
        );
        if ($validator->fails()) {
            return 'Invalid email address.';
        }
        $ticket_id = Input::get('ticket_id');
        $user_search = User::where('email', '=', $email)->first();
        if (isset($user_serach)) {
            return '<div id="alert11" class="alert alert-warning alert-dismissable" ><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-alert"></i>Alert!</h4><div id="message-success1">This user already Exists</div></div>';
        } else {
            $company = $this->company();
            $user = new User();
            $user->first_name = $name;
            $user->user_name = $email;
            $user->email = $email;
            $password = $this->generateRandomString();
            $user->password = \Hash::make($password);
            $user->role = 'user';
            $user->active = 1;
            if ($user->save()) {
                $user_id = $user->id;

                $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to
                        = ['name' => $name, 'email' => $email], $message = ['subject' => 'Password', 'scenario' => 'registration-notification'], $template_variables
                        = ['user' => $name, 'email_address' => $email, 'user_password' => $password]);
            }
            $ticket_collaborator = new Ticket_Collaborator();
            $ticket_collaborator->isactive = 1;
            $ticket_collaborator->ticket_id = $ticket_id;
            $ticket_collaborator->user_id = $user->id;
            $ticket_collaborator->role = 'ccc';
            $ticket_collaborator->save();

            return '<div id="alert11" class="alert alert-dismissable" style="color:#60B23C;background-color:#F2F2F2;"><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-user"></i>'.$user->user_name.'</h4><div id="message-success1">'.$user->email.'</div></div>';
        }
    }

    /**
     * user remove.
     *
     * @return type
     */
    public function userremove()
    {
        $id = Input::get('data1');
        $ticket_collaborator = Ticket_Collaborator::where('id', '=', $id)->delete();

        return 1;
    }

    /**
     * select_all.
     *
     * @return type
     */
    public function select_all()
    {
        if (Input::has('select_all')) {
            $selectall = Input::get('select_all');
            $value = Input::get('submit');
            foreach ($selectall as $delete) {
                $ticket = Tickets::whereId($delete)->first();
                if ($value == 'Delete') {
                    $this->delete($delete, new Tickets());
                } elseif ($value == 'Close') {
                    $this->close($delete, new Tickets());
                } elseif ($value == 'Open') {
                    $this->open($delete, new Tickets());
                } elseif ($value == 'Delete forever') {
                    $notification = Notification::select('id')->where('model_id', '=', $ticket->id)->get();
                    foreach ($notification as $id) {
                        $user_notification = UserNotification::where(
                                        'notification_id', '=', $id->id);
                        $user_notification->delete();
                    }
                    $notification = Notification::select('id')->where('model_id', '=', $ticket->id);
                    $notification->delete();
                    $thread = Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
                    foreach ($thread as $th_id) {
                        // echo $th_id->id." ";
                        $attachment = Ticket_attachments::where('thread_id', '=', $th_id->id)->get();
                        if (count($attachment)) {
                            foreach ($attachment as $a_id) {
                                // echo $a_id->id . ' ';
                                $attachment = Ticket_attachments::find($a_id->id);
                                $attachment->delete();
                            }
                            // echo "<br>";
                        }
                        $thread = Ticket_Thread::find($th_id->id);
//                        dd($thread);
                        $thread->delete();
                    }
                    $collaborators = Ticket_Collaborator::where('ticket_id', '=', $ticket->id)->get();
                    if (count($collaborators)) {
                        foreach ($collaborators as $collab_id) {
                            // echo $collab_id->id;
                            $collab = Ticket_Collaborator::find($collab_id->id);
                            $collab->delete();
                        }
                    }
                    $tickets = Tickets::find($ticket->id);
                    $tickets->delete();
                    $data = ['id' => $ticket->id];
                    \Event::fire('ticket-permanent-delete', [$data]);
                }
            }
            if ($value == 'Delete') {
                return redirect()->back()->with('success', lang::get('lang.moved_to_trash'));
            } elseif ($value == 'Close') {
                return redirect()->back()->with('success', Lang::get('lang.tickets_have_been_closed'));
            } elseif ($value == 'Open') {
                return redirect()->back()->with('success', Lang::get('lang.tickets_have_been_opened'));
            } else {
                return redirect()->back()->with('success', Lang::get('lang.hard-delete-success-message'));
            }
        }

        return redirect()->back()->with('fails', 'None Selected!');
    }

    /**
     * user time zone.
     *
     * @param type $utc
     *
     * @return type date
     */
    public static function usertimezone($utc)
    {
        $set = System::whereId('1')->first();
        $timezone = Timezones::whereId($set->time_zone)->first();
        $tz = $timezone->name;
        $format = $set->date_time_format;
        date_default_timezone_set($tz);
        $offset = date('Z', strtotime($utc));
        $format = Date_time_format::whereId($format)->first()->format;
        $date = date($format, strtotime($utc) + $offset);

        return $date;
    }

    /**
     * adding offset to updated_at time.
     *
     * @return date
     */
    public static function timeOffset($utc)
    {
        $set = System::whereId('1')->first();
        $timezone = Timezones::whereId($set->time_zone)->first();
        $tz = $timezone->name;
        date_default_timezone_set($tz);
        $offset = date('Z', strtotime($utc));

        return $offset;
    }

    /**
     * to get user date time format.
     *
     * @return string
     */
    public static function getDateTimeFormat()
    {
        $set = System::select('date_time_format')->whereId('1')->first();

        return $set->date_time_format;
    }

    /**
     * lock.
     *
     * @param type $id
     *
     * @return type null
     */
    public function lock($id)
    {
        $ticket = Tickets::where('id', '=', $id)->first();
        $ticket->lock_by = Auth::user()->id;
        $ticket->lock_at = date('Y-m-d H:i:s');
        $ticket->save();
    }

    /**
     * Show the deptopen ticket list page.
     *
     * @return type response
     */
    public function deptopen($id)
    {
        $dept = Department::where('name', '=', $id)->first();
        if (Auth::user()->role == 'agent') {
            if (Auth::user()->primary_dpt == $dept->id) {
                return view('themes.default1.agent.helpdesk.dept-ticket.tickets', compact('id'));
            } else {
                return redirect()->back()->with('fails', 'Unauthorised!');
            }
        } else {
            return view('themes.default1.agent.helpdesk.dept-ticket.tickets', compact('id'));
        }
    }

    public function deptTicket($dept, $status)
    {
        if (\Auth::user()->role === 'agent') {
            $dept2 = Department::where('id', '=', \Auth::user()->primary_dpt)->first();
            if ($dept !== $dept2->name) {
                return redirect()->back()->with('fails', Lang::get('lang.unauthorized_access'));
            }
        }
        $table = \Datatable::table()
                ->addColumn(
                        '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                ->noScript();

        return view('themes.default1.agent.helpdesk.dept-ticket.tickets', compact('dept', 'status', 'table'));
    }

    /**
     * Show the deptclose ticket list page.
     *
     * @return type response
     */
    public function deptclose($id)
    {
        $dept = Department::where('name', '=', $id)->first();
        if (Auth::user()->role == 'agent') {
            if (Auth::user()->primary_dpt == $dept->id) {
                return view('themes.default1.agent.helpdesk.dept-ticket.closed', compact('id'));
            } else {
                return redirect()->back()->with('fails', 'Unauthorised!');
            }
        } else {
            return view('themes.default1.agent.helpdesk.dept-ticket.closed', compact('id'));
        }
    }

    /**
     * Show the deptinprogress ticket list page.
     *
     * @return type response
     */
    public function deptinprogress($id)
    {
        $dept = Department::where('name', '=', $id)->first();
        if (Auth::user()->role == 'agent') {
            if (Auth::user()->primary_dpt == $dept->id) {
                return view('themes.default1.agent.helpdesk.dept-ticket.inprogress', compact('id'));
            } else {
                return redirect()->back()->with('fails', 'Unauthorised!');
            }
        } else {
            return view('themes.default1.agent.helpdesk.dept-ticket.inprogress', compact('id'));
        }
    }

    /**
     * Store ratings of the user.
     *
     * @return type Redirect
     */
    public function rating($id, Request $request, \App\Model\helpdesk\Ratings\RatingRef $rating_ref)
    {
        foreach ($request->all() as $key => $value) {
            if ($key == '_token') {
                continue;
            }
            if (strpos($key, '_') !== false) {
                $ratName = str_replace('_', ' ', $key);
            } else {
                $ratName = $key;
            }
            $ratID = \App\Model\helpdesk\Ratings\Rating::where('name', '=', $ratName)->first();
            $ratingrefs = $rating_ref->where('rating_id', '=', $ratID->id)->where('ticket_id', '=', $id)->first();
            if ($ratingrefs !== null) {
                $ratingrefs->rating_id = $ratID->id;
                $ratingrefs->ticket_id = $id;

                $ratingrefs->thread_id = '0';
                $ratingrefs->rating_value = $value;
                $ratingrefs->save();
            } else {
                $rating_ref->rating_id = $ratID->id;
                $rating_ref->ticket_id = $id;

                $rating_ref->thread_id = '0';
                $rating_ref->rating_value = $value;
                $rating_ref->save();
            }
        }

        return redirect()->back()->with('Success', 'Thank you for your rating!');
    }

    /**
     * Store Client rating about reply of agent quality.
     *
     * @return type Redirect
     */
    public function ratingReply($id, Request $request, \App\Model\helpdesk\Ratings\RatingRef $rating_ref)
    {
        foreach ($request->all() as $key => $value) {
            if ($key == '_token') {
                continue;
            }
            $key1 = explode(',', $key);
            if (strpos($key1[0], '_') !== false) {
                $ratName = str_replace('_', ' ', $key1[0]);
            } else {
                $ratName = $key1[0];
            }

            $ratID = \App\Model\helpdesk\Ratings\Rating::where('name', '=', $ratName)->first();
            $ratingrefs = $rating_ref->where('rating_id', '=', $ratID->id)->where('thread_id', '=', $key1[1])->first();

            if ($ratingrefs !== null) {
                $ratingrefs->rating_id = $ratID->id;
                $ratingrefs->ticket_id = $id;

                $ratingrefs->thread_id = $key1[1];
                $ratingrefs->rating_value = $value;
                $ratingrefs->save();
            } else {
                $rating_ref->rating_id = $ratID->id;
                $rating_ref->ticket_id = $id;

                $rating_ref->thread_id = $key1[1];
                $rating_ref->rating_value = $value;
                $rating_ref->save();
            }
        }

        return redirect()->back()->with('Success', 'Thank you for your rating!');
    }

    /**
     * System default email.
     */
    public function system_mail()
    {
        $email = Email::where('id', '=', '1')->first();

        return $email->sys_email;
    }

    /**
     * checkLock($id)
     * function to check and lock ticket.
     *
     * @param int $id
     *
     * @return int
     */
    public function checkLock($id)
    {
        $ticket = DB::table('tickets')->select('id', 'lock_at', 'lock_by')->where('id', '=', $id)->first();
        $cad = DB::table('settings_ticket')->select('collision_avoid')->where('id', '=', 1)->first();
        $cad = $cad->collision_avoid; //collision avoid duration defined in system

        $to_time = strtotime($ticket->lock_at); //last locking time

        $from_time = time(); //user system's cureent time
        // difference in last locking time and user system's current time
        $diff = round(abs($to_time - $from_time) / 60, 2);

        if ($diff < $cad && Auth::user()->id != $ticket->lock_by) {
            $user_data = User::select('user_name', 'first_name', 'last_name')->where('id', '=', $ticket->lock_by)->first();
            if ($user_data->first_name != '') {
                $name = $user_data->first_name.' '.$user_data->last_name;
            } else {
                $name = $user_data->username;
            }

            return Lang::get('lang.locked-ticket')." <a href='".route('user.show', $ticket->lock_by)."'>".$name.'</a>&nbsp;'.$diff.'&nbsp'.Lang::get('lang.minutes-ago');  //ticket is locked
        } elseif ($diff < $cad && Auth::user()->id == $ticket->lock_by) {
            $ticket = Tickets::where('id', '=', $id)->first();
            $ticket->lock_at = date('Y-m-d H:i:s');
            $ticket->save();

            return 4;  //ticket is locked by same user who is requesting access
        } else {
            if (Auth::user()->id == $ticket->lock_by) {
                $ticket = Tickets::where('id', '=', $id)->first();
                $ticket->lock_at = date('Y-m-d H:i:s');
                $ticket->save();

                return 1; //ticket is available and lock ticket for the same user who locked ticket previously
            } else {
                $ticket = Tickets::where('id', '=', $id)->first();
                $ticket->lock_by = Auth::user()->id;
                $ticket->lock_at = date('Y-m-d H:i:s');
                $ticket->save(); //ticket is available and lock ticket for new user
                return 2;
            }
        }
    }

    /**
     * function to Change owner.
     *
     * @param type $id
     *
     * @return type bool
     */
    public function changeOwner($id)
    {
        $action = Input::get('action');
        $email = Input::get('email');
        $ticket_id = Input::get('ticket_id');
        $send_mail = Input::get('send-mail');

        if ($action === 'change-add-owner') {
            $name = Input::get('name');
            $returnValue = $this->changeOwnerAdd($email, $name, $ticket_id);
            if ($returnValue === 0) {
                return 4;
            } elseif ($returnValue === 2) {
                return 5;
            } else {
                //do nothing
            }
        }
        $user = User::where('email', '=', $email)->first();
        $count = count($user);
        if ($count === 1) {
            $user_id = $user->id;
            $ticket = Tickets::where('id', '=', $id)->first();
            if ($user_id === (int) $ticket->user_id) {
                return 400;
            }
            $ticket_number = $ticket->ticket_number;
            $ticket->user_id = $user_id;
            $ticket->save();
            $ticket_thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
            $ticket_subject = $ticket_thread->title;
            $thread = new Ticket_Thread();
            $thread->ticket_id = $ticket->id;
            $thread->user_id = Auth::user()->id;
            $thread->is_internal = 1;
            $thread->body = 'This ticket now belongs to '.$user->user_name;
            $thread->save();

            //mail functionality
            $company = $this->company();
            $system = $this->system();

            $agent = $user->first_name;
            $agent_email = $user->email;

            $master = Auth::user()->first_name.' '.Auth::user()->last_name;
            if (Alert::first()->internal_status == 1 || Alert::first()->internal_assigned_agent
                    == 1) {
                // ticket assigned send mail
                Mail::send('emails.Ticket_assign', ['agent' => $agent, 'ticket_number' => $ticket_number, 'from' => $company, 'master' => $master, 'system' => $system], function ($message) use ($agent_email, $agent, $ticket_number, $ticket_subject) {
                    $message->to($agent_email, $agent)->subject($ticket_subject.'[#'.$ticket_number.']');
                });
            }

            return 1;
        } else {
            return 0;
        }
    }

    /**
     * useradd.
     *
     * @param type Image $image
     *
     * @return type json
     */
    public function changeOwnerAdd($email, $name, $ticket_id)
    {
        $name = $name;
        $email = $email;
        $ticket_id = $ticket_id;
        $validator = \Validator::make(
                        ['email' => $email,
                    'name'       => $name, ], ['email'      => 'required|email',
                        ]
        );
        $user = User::where('email', '=', $email)->first();
        $count = count($user);
        if ($count === 1) {
            return 0;
        } elseif ($validator->fails()) {
            return 2;
        } else {
            $company = $this->company();
            $user = new User();
            $user->user_name = $name;
            $user->email = $email;
            $password = $this->generateRandomString();
            $user->password = \Hash::make($password);
            $user->role = 'user';
            if ($user->save()) {
                $user_id = $user->id;

                try {
                    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to
                            = ['name' => $name, 'email' => $email], $message = ['subject' => 'Password', 'scenario' => 'registration-notification'], $template_variables
                            = ['user' => $name, 'email_address' => $email, 'user_password' => $password]);
                } catch (\Exception $e) {
                }
            }

            return 1;
        }
    }

    public function getMergeTickets($id)
    {
        if ($id == 0) {
            $t_id = Input::get('data1');
            foreach ($t_id as $value) {
                $title = Ticket_Thread::select('title')->where('ticket_id', '=', $value)->first();
                echo "<option value='$value'>".$title->title.'</option>';
            }
        } else {
            $ticket = Tickets::select('user_id')->where('id', '=', $id)->first();
            $ticket_data = Tickets::select('ticket_number', 'id')
                            ->where('user_id', '=', $ticket->user_id)->where('id', '!=', $id)->where('status', '=', 1)->get();
            foreach ($ticket_data as $value) {
                $title = Ticket_Thread::select('title')->where('ticket_id', '=', $value->id)->first();
                echo "<option value='$value->id'>".$title->title.'</option>';
            }
        }
    }

    public function checkMergeTickets($id)
    {
        if ($id == 0) {
            if (Input::get('data1') == null || count(Input::get('data1')) == 1) {
                return 0;
            } else {
                $t_id = Input::get('data1');
                $previousValue = null;
                $match = 1;
                foreach ($t_id as $value) {
                    $ticket = Tickets::select('user_id')->where('id', '=', $value)->first();
                    if ($previousValue == null || $previousValue == $ticket->user_id) {
                        $previousValue = $ticket->user_id;
                        $match = 1;
                    } else {
                        $match = 2;
                        break;
                    }
                }

                return $match;
            }
        } else {
            $ticket = Tickets::select('user_id')->where('id', '=', $id)->first();
            $ticket_data = Tickets::select('ticket_number', 'id')
                            ->where('user_id', '=', $ticket->user_id)
                            ->where('id', '!=', $id)
                            ->where('status', '=', 1)->get();
            if (isset($ticket_data) && count($ticket_data) >= 1) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function mergeTickets($id)
    {
        // split the phrase by any number of commas or space characters,
        // which include " ", \r, \t, \n and \f
        $t_id = preg_split("/[\s,]+/", $id);
        if (count($t_id) > 1) {
            $p_id = Input::get('p_id'); //parent ticket id
            $t_id = array_diff($t_id, [$p_id]);
        } else {
            $t_id = Input::get('t_id'); //getting array of tickets to merge
            if ($t_id == null) {
                return 2;
            } else {
                $temp_id = Input::get('p_id'); //getting parent ticket
                if ($id == $temp_id) {
                    $p_id = $id;
                } else {
                    $p_id = $temp_id;
                    array_push($t_id, $id);
                    $t_id = array_diff($t_id, [$temp_id]);
                }
            }
        }
        $parent_ticket = Tickets::select('ticket_number')->where('id', '=', $p_id)->first();
        $parent_thread = Ticket_Thread::where('ticket_id', '=', $p_id)->first();
        foreach ($t_id as $value) {//to create new thread of the tickets to be merged with parent
            $thread = Ticket_Thread::where('ticket_id', '=', $value)->first();
            $ticket = Tickets::select('ticket_number')->where('id', '=', $value)->first();
            Ticket_Thread::where('ticket_id', '=', $value)
                    ->update(['ticket_id' => $p_id]);
            Ticket_Form_Data::where('ticket_id', '=', $value)
                    ->update(['ticket_id' => $p_id]);
            Ticket_Collaborator::where('ticket_id', '=', $value)
                    ->update(['ticket_id' => $p_id]);
            Tickets::where('id', '=', $value)
                    ->update(['status' => 3]);
            //event has $p_id and $value
            \Event::fire('ticket.merge', [['parent' => $p_id, 'child' => $value]]);
            if (!empty(Input::get('reason'))) {
                $reason = Input::get('reason');
            } else {
                $reason = Lang::get('lang.no-reason');
            }
            if (!empty(Input::get('title'))) {
                Ticket_Thread::where('ticket_id', '=', $p_id)->first()
                        ->update(['title' => Input::get('title')]);
            }

            $new_thread = new Ticket_Thread();
            $new_thread->ticket_id = $thread->ticket_id;
            $new_thread->user_id = Auth::user()->id;
            $new_thread->is_internal = 0;
            $new_thread->title = $thread->title;
            $new_thread->body = Lang::get('lang.get_merge_message').
                    "&nbsp;&nbsp;<a href='".route('ticket.thread', [$p_id]).
                    "'>#".$parent_ticket->ticket_number.'</a><br><br><b>'.Lang::get('lang.merge-reason').':</b>&nbsp;&nbsp;'.$reason;
            $new_thread->format = $thread->format;
            $new_thread->ip_address = $thread->ip_address;

            $new_parent_thread = new Ticket_Thread();
            $new_parent_thread->ticket_id = $p_id;
            $new_parent_thread->user_id = Auth::user()->id;
            $new_parent_thread->is_internal = 1;
            $new_parent_thread->title = $thread->title;
            $new_parent_thread->body = Lang::get('lang.ticket')."&nbsp;<a href='".route('ticket.thread', [$value])."'>#".$ticket->ticket_number.'</a>&nbsp'.Lang::get('lang.ticket_merged').'<br><br><b>'.Lang::get('lang.merge-reason').':</b>&nbsp;&nbsp;'.$reason;
            $new_parent_thread->format = $parent_thread->format;
            $new_parent_thread->ip_address = $parent_thread->ip_address;
            if ($new_thread->save() && $new_parent_thread->save()) {
                $success = 1;
            } else {
                $success = 0;
            }
        }
        $this->sendMergeNotification($p_id, $t_id);

        return $success;
    }

    public function getParentTickets($id)
    {
        $title = Ticket_Thread::select('title')->where('ticket_id', '=', $id)->first();
        echo "<option value='$id'>".$title->title.'</option>';
        $tickets = Input::get('data1');
        foreach ($tickets as $value) {
            $title = Ticket_Thread::select('title')->where('ticket_id', '=', $value)->first();
            echo "<option value='$value'>".$title->title.'</option>';
        }
    }

    /*
     * chumper's function to return data to chumper datatable.
     * @param Array-object $tickets
     *
     * @return Array-object
     */
    public static function getTable($tickets)
    {
        return \Datatables::of($tickets)
                        ->editColumn('id', function ($tickets) {
                            $rep = ($tickets->last_replier == 'client') ? '#F39C12'
                                        : '#000';

                            return "<center><input type='checkbox' name='select_all[]' id='".$tickets->id."' onclick='someFunction(this.id)' class='selectval icheckbox_flat-blue ".$tickets->color.' '.$rep."' value='".$tickets->id."'></input></center>";
                        })
                        ->addColumn('title', function ($tickets) {
                            if (isset($tickets->ticket_title)) {
                                $string = utfEncoding($tickets->ticket_title);
                                if (strlen($string) > 25) {
                                    $string = str_limit($string, 30).'...';
                                }
                            } else {
                                $string = Lang::get('lang.no-subject');
                            }

                            $collab = $tickets->countcollaborator;
                            if ($collab > 0) {
                                $collabString = '&nbsp;<i class="fa fa-users" title="'.Lang::get('lang.ticket_has_collaborator').'"></i>';
                            } else {
                                $collabString = null;
                            }

                            $attachCount = $tickets->countattachment;
                            if ($attachCount > 0) {
                                $attachString = '&nbsp;<i class="fa fa-paperclip" title="'.Lang::get('lang.ticket_has_attachments').'"></i>';
                            } else {
                                $attachString = '';
                            }

                            $css = $tickets->css;
                            $source = $tickets->source;
                            $titles = '';
                            if ($tickets->ticket_title) {
                                $titles = $tickets->ticket_title;
                            }

                            $due = '';
                            if ($tickets->duedate != null) {
                                $now = strtotime(\Carbon\Carbon::now()->tz(timezone()));
                                $duedate = strtotime($tickets->duedate);

                                if ($duedate - $now < 0) {
                                    $due = '&nbsp;<span style="background-color: rgba(221, 75, 57, 0.67) !important" title="'.Lang::get('lang.is_overdue').'" class="label label-danger">'.Lang::get('lang.overdue').'</span>';
                                } else {
                                    if (date('Ymd', $duedate) == date('Ymd', $now)) {
                                        $due = '&nbsp;<span style="background-color: rgba(240, 173, 78, 0.67) !important" title="'.Lang::get('lang.going-overdue-today').'" class="label label-warning">'.Lang::get('lang.duetoday').'</span>';
                                    }
                                }
                            }

                            $thread_count = '('.$tickets->countthread.')';
                            if (Lang::getLocale() == 'ar') {
                                $thread_count = '&rlm;('.$tickets->countthread.')';
                            }

                            $tooltip_script = self::tooltip($tickets->id);

                            return "<div class='tooltip1' id='tool".$tickets->id."'>
                            <a href='".route('ticket.thread', [$tickets->id])."'>".$string."&nbsp;<span style='color:green'>".$thread_count."</span>
                            </a> <span><i style='color:green' title='".Lang::get('lang.ticket_created_source', ['source' => $source])."' class='".$css."'></i></span>".$collabString.$attachString.$due.$tooltip_script.
                                    "<span class='tooltiptext' id='tooltip".$tickets->id."' style='height:auto;width:300px;background-color:#fff;color:black;border-radius:3px;border:2px solid gainsboro;position:absolute;z-index:1;top:150%;left:50%;margin-left:-23px;word-wrap:break-word;'>".Lang::get('lang.loading').'</span></div>';
                        })
                        ->editColumn('ticket_number', function ($tickets) {
                            return "<a href='".route('ticket.thread', [$tickets->id])."' class='$".ucfirst($tickets->priority)."*' title='".Lang::get('lang.click-here-to-see-more-details')."'>#".$tickets->ticket_number.'</a>';
                        })
                        ->editColumn('c_uname', function ($tickets) {
                            $from = $tickets->c_fname;
                            $url = route('user.show', $tickets->c_uid);
                            $name = $tickets->c_uname;
                            if ($from) {
                                $name = utfEncoding($tickets->c_fname).' '.utfEncoding($tickets->c_lname);
                            }

                            $color = '';
                            if ($tickets->verified == 0 || $tickets->verified == '0') {
                                $color = "<i class='fa fa-exclamation-triangle'  title='".Lang::get('lang.accoutn-not-verified')."'></i>";
                            }

                            return "<a href='".$url."' title='".Lang::get('lang.see-profile1').' '.$name.'&apos;'.Lang::get('lang.see-profile2')."'><span style='color:#508983'>".str_limit($name, 30).' <span style="color:#f75959">'.$color.'</span></span></a>';
                        })
                        ->editColumn('a_uname', function ($tickets) {
                            if ($tickets->assigned_to == null && $tickets->name == null) {
                                return "<span style='color:red'>Unassigned</span>";
                            } else {
                                $assign = $tickets->assign_user_name;
                                if ($tickets->assigned_to != null) {
                                    $assign = utfEncoding($tickets->a_fname).' '.utfEncoding($tickets->a_lname);
                                    $url = route('user.show', $tickets->assigned_to);

                                    return "<a href='".$url."' title='".Lang::get('lang.see-profile1').' '.$assign.'&apos;'.Lang::get('lang.see-profile2')."'><span style='color:green'>".mb_substr($assign, 0, 30, 'UTF-8').'</span></a>';
                                } else {
                                    $url1 = '#';

                                    return "<a href='".$url1."' title='".Lang::get('lang.see-profile1').' '.ucfirst($tickets->name).'&apos;'.Lang::get('lang.see-profile2')."'><span style='color:green'>".mb_substr(ucfirst($tickets->name), 0, 30, 'UTF-8').'</span></a>';
                                }
                            }
                        })
                        ->editColumn('updated_at', function ($tickets) {
                            $TicketDatarow = $tickets->updated_at;
                            $updated = '--';
                            if ($TicketDatarow) {
                                $updated = faveoDate($tickets->updated_at);
                            }

                            return '<span style="display:none">'.$updated.'</span>'.$updated;
                        })
                        ->make();
    }

    /**
     * @category function to call and show ticket details in tool tip via ajax
     *
     * @param null
     *
     * @return string //script to load tooltip data
     */
    public static function tooltip($ticketid)
    {
        return "<script>
                var timeoutId;
                $('#tool".$ticketid."').hover(function() {
                    if (!timeoutId) {
                        timeoutId = window.setTimeout(function() {
                        timeoutId = null; // EDIT: added this line
                                $.ajax({
                                url:'".url('ticket/tooltip')."',
                                dataType:'html',
                                type:'get',
                                data:{'ticketid':".$ticketid."},
                                success : function(html){
                                    $('#tooltip".$ticketid."').html(html);
                                },
                            });
                        }, 2000);
                    }
                },
                function () {
                    if (timeoutId) {
                        window.clearTimeout(timeoutId);
                        timeoutId = null;
                    } else {
                    }
                });
                </script>";
    }

    public function getTooltip(Request $request)
    {
        $ticketid = $request->input('ticketid');
        $ticket = Tickets::find($ticketid);
        $firstThread = $ticket->thread()->select('user_id', 'poster', 'body')->first();
        $lastThread = $ticket->thread()->select('user_id', 'poster', 'body')->orderBy('id', 'desc')->first();

        return '<b>'.$firstThread->user->user_name.' ('.$firstThread->poster.')</b></br>'
                .$firstThread->purify().'<br><hr>'
                .'<b>'.$lastThread->user->user_name.'('.$lastThread->poster.')</b>'
                .$lastThread->purify().'<br><hr>';
    }

    //Auto-close tickets
    public function autoCloseTickets()
    {
        $workflow = \App\Model\helpdesk\Workflow\WorkflowClose::whereId(1)->first();

        if ($workflow->condition == 1) {
            $overdues = Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->orderBy('id', 'DESC')->get();
            if (count($overdues) == 0) {
                $tickets = null;
            } else {
                $i = 0;
                foreach ($overdues as $overdue) {
                    //                $sla_plan = Sla_plan::where('id', '=', $overdue->sla)->first();

                    $ovadate = $overdue->created_at;
                    $new_date = date_add($ovadate, date_interval_create_from_date_string($workflow->days.' days')).'<br/><br/>';
                    if (date('Y-m-d H:i:s') > $new_date) {
                        $i++;
                        $overdue->status = 3;
                        $overdue->closed = 1;
                        $overdue->closed_at = date('Y-m-d H:i:s');
                        $overdue->save();
//        if($workflow->send_email == 1) {
//             $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $overdue->dept_id), $to = ['name' => $user_name, 'email' => $email], $message = ['subject' => $ticket_subject.'[#'.$ticket_number.']', 'scenario' => 'close-ticket'], $template_variables = ['ticket_number' => $ticket_number]);
//        }
                    }
                }
                // dd(count($value));
//            if ($i > 0) {
//                $tickets = new collection($value);
//            } else {
//                $tickets = null;
//            }
            }
        } else {
        }
    }

    /**
     * @category function to chech if user verifcaition required for creating tickets or not
     *
     * @param null
     *
     * @return int 0/1
     */
    public function checkUserVerificationStatus()
    {
        $status = CommonSettings::select('status')
                ->where('option_name', '=', 'send_otp')
                ->first();
        if ($status->status == 0 || $status->status == '0') {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * This function is used for auto filling in new ticket.
     *
     * @return type view
     */
    public function autofill()
    {
        return view('themes.default1.agent.helpdesk.ticket.getautocomplete');
    }

    public function pdfThread($threadid)
    {
        try {
            $threads = new Ticket_Thread();
            $thread = $threads->leftJoin('tickets', 'ticket_thread.ticket_id', '=', 'tickets.id')
                    ->leftJoin('users', 'ticket_thread.user_id', '=', 'users.id')
                    ->where('ticket_thread.id', $threadid)
                    ->first();
            //dd($thread);
            if (!$thread) {
                throw new Exception('Sorry we can not find your request');
            }
            $company = \App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
            $system = \App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
            $ticket = Tickets::where('id', $thread->ticket_id)->first();
            $html = view('themes.default1.agent.helpdesk.ticket.thread-pdf', compact('thread', 'system', 'company', 'ticket'))->render();
            $html1 = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

            return PDF::load($html1)->show();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public static function getSourceByname($name)
    {
        $sources = new Ticket_source();
        $source = $sources->where('name', $name)->first();

        return $source;
    }

    public static function getSourceById($sourceid)
    {
        $sources = new Ticket_source();
        $source = $sources->where('id', $sourceid)->first();

        return $source;
    }

    public static function getSourceCssClass($sourceid)
    {
        $css = 'fa fa-comment';
        $source = self::getSourceById($sourceid);
        if ($source) {
            $css = $source->css_class;
        }

        return $css;
    }

    public function getSystemDefaultHelpTopic()
    {
        $ticket_settings = new \App\Model\helpdesk\Settings\Ticket();
        $ticket_setting = $ticket_settings->find(1);
        $help_topicid = $ticket_setting->help_topic;

        return $help_topicid;
    }

    public function getSystemDefaultSla()
    {
        $ticket_settings = new \App\Model\helpdesk\Settings\Ticket();
        $ticket_setting = $ticket_settings->find(1);
        $sla = $ticket_setting->sla;

        return $sla;
    }

    public function getSystemDefaultPriority()
    {
        $ticket_settings = new \App\Model\helpdesk\Settings\Ticket();
        $ticket_setting = $ticket_settings->find(1);
        $priority = $ticket_setting->priority;

        return $priority;
    }

    public function getSystemDefaultDepartment()
    {
        $systems = new \App\Model\helpdesk\Settings\System();
        $system = $systems->find(1);
        $department = $system->department;

        return $department;
    }

    public function findTicketFromTicketCreateUser($result = [])
    {
        $ticket_number = $this->checkArray('0', $result);
        if ($ticket_number !== '') {
            $tickets = new \App\Model\helpdesk\Ticket\Tickets();
            $ticket = $tickets->where('ticket_number', $ticket_number)->first();
            if ($ticket) {
                return $ticket;
            }
        }
    }

    public function findUserFromTicketCreateUserId($result = [])
    {
        $ticket = $this->findTicketFromTicketCreateUser($result);
        if ($ticket) {
            $userid = $ticket->user_id;

            return $userid;
        }
    }

    public function checkArray($key, $array)
    {
        $value = '';
        if (array_key_exists($key, $array)) {
            $value = $array[$key];
        }

        return $value;
    }

    public function getAdmin()
    {
        $users = new \App\User();
        $admin = $users->where('role', 'admin')->first();

        return $admin;
    }

    public function attachmentSeperateOld($attach)
    {
        $attacment = [];
        if ($attach != null) {
            $size = count($attach);
            for ($i = 0; $i < $size; $i++) {
                $file_name = $attach[$i]->getClientOriginalName();
                $file_path = $attach[$i]->getRealPath();
                $mime = $attach[$i]->getClientMimeType();
                $attacment[$i]['file_name'] = $file_name;
                $attacment[$i]['file_path'] = $file_path;
                $attacment[$i]['mime'] = $mime;
            }
        }

        return $attacment;
    }

    public function attachmentSeperate($thread_id)
    {
        if ($thread_id) {
            $array = [];
            $attachment = new Ticket_attachments();
            $attachments = $attachment->where('thread_id', $thread_id)->get();
            if ($attachments->count() > 0) {
                foreach ($attachments as $key => $attach) {
                    $array[$key]['file_path'] = $attach->file;
                    $array[$key]['file_name'] = $attach->name;
                    $array[$key]['mime'] = $attach->type;
                    $array[$key]['mode'] = 'data';
                }

                return $array;
            }
        }
    }

    /**
     * @return type
     */
    public function followupTicketList()
    {
        try {
            $table = \Datatable::table()
                    ->addColumn(
                            '', Lang::get('lang.subject'), Lang::get('lang.ticket_id'), Lang::get('lang.priority'), Lang::get('lang.from'), Lang::get('lang.assigned_to'), Lang::get('lang.last_activity'), Lang::get('lang.created-at'))
                    ->noScript();

            return view('themes.default1.agent.helpdesk.followup.followup', compact('table'));
        } catch (Exception $e) {
            return Redirect()->back()->with('fails', $e->getMessage());
        }
    }

    public static function getSubject($subject)
    {
        //$subject = $this->attributes['title'];
        $array = imap_mime_header_decode($subject);
        $title = '';
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $text) {
                $title .= $text->text;
            }

            return wordwrap($title, 70, "<br>\n");
        }

        return wordwrap($subject, 70, "<br>\n");
    }

    public function replyContent($content)
    {
        preg_match_all('/<img[^>]+>/i', $content, $result);
        $url = [];
        $encode = [];
        $img = [];
        foreach ($result as $key => $img_tag) {
            //dd($img_tag);
            preg_match_all('/(src)=("[^"]*")/i', $img_tag[$key], $img[$key]);
        }
        for ($i = 0; $i < count($img); $i++) {
            $url = $img[$i][2][0];
            $encode = $this->divideUrl($img[$i][2][0]);
        }

        return str_replace($url, $encode, $content);
    }

    public function divideUrl($url)
    {
        $baseurl = url('/');
        $trim = str_replace($baseurl, '', $url);
        $trim = str_replace('"', '', $trim);
        $trim = substr_replace($trim, '', 0, 1);
        $path = public_path($trim);

        return $this->fileContent($path);
    }

    public function fileContent($path)
    {
        $exist = \File::exists($path);
        $base64 = '';
        if ($exist) {
            $content = \File::get($path);
            $type = \File::extension($path);
            $base64 = 'data:image/'.$type.';base64,'.base64_encode($content);
        }

        return $base64;
    }

    /**
     * @category function to send notification of ticket merging to the owners
     *
     * @param srting array $t_id, $p_id
     *
     * @return null
     */
    public function sendMergeNotification($p_id, $t_id)
    {
        try {
            $ticket_details = Tickets::select('ticket_number', 'user_id', 'dept_id')->where('id', '=', $p_id)->first();
            $user_detail = User::where('id', '=', $ticket_details->user_id)->first();
            if ($user_detail->count() > 0) {
                if ($user_detail->email !== null || $user_detail->email !== '') {
                    $meged_ticket_details = Tickets::select('ticket_number')->whereIn('id', $t_id)->get();
                    $child_ticket_numbers = [];
                    foreach ($meged_ticket_details as $value) {
                        array_push($child_ticket_numbers, $value->ticket_number);
                    }
                    // dd(implode(", ",$child_ticket_numbers), $ticket_details->ticket_number);
                    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticket_details->dept_id), $to
                            = ['user' => $user_detail->full_name, 'email' => $user_detail->email], $message
                            = ['subject' => '', 'body' => '', 'scenario' => 'merge-ticket-notification'], $template_variables
                            = ['user' => $user_detail->full_name, 'ticket_number' => $ticket_details->ticket_number, 'ticket_link' => route('ticket.thread', $p_id), 'merged_ticket_numbers' => implode(', ', $child_ticket_numbers)]);
                }
            }
        } catch (\Exception $e) {
            //catch the exception
        }
    }

    public function ticketChangeDepartment(Request $request)
    {
        if (!$this->ticket_policy->transfer()) {
            if ($api) {
                return response()->json(['message' => 'permission denied'], 403);
            }

            return redirect('dashboard')->with('fails', 'Permission denied');
        }
        $match_dept_name = Department::where('name', '=', $request->tkt_dept_transfer)->select('id')->first();
        if (!$match_dept_name) {
            return redirect()->back()->with('fails', Lang::get('lang.this_deparment_not_exists'));
        } else {
            $ticket_id = $request->tkt_id;
            $ticket = Tickets::findOrFail($ticket_id);
            $ticket->dept_id = $match_dept_name->id;
            $sla = $this->getSla($ticket->type, $ticket->user_id, $match_dept_name->id, $ticket->source, $ticket->priority_id);
            $ticket = $this->updateOverdue($ticket, $sla);
            $ticket->save();

            return redirect()->back()->with('success', Lang::get('lang.ticket_department_successfully_changed'));
        }
    }

    public function getDepartmentSign($id)
    {
        $sign = '';
        $dept = Department::select('department_sign')->where('id', '=', $id)->first();
        if ($dept) {
            $sign = $dept->department_sign;
        }

        return $sign;
    }
}
