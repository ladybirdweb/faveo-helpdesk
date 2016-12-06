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
use App\Model\helpdesk\Form\Fields;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
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
use Exception;
use GeoIP;
// classes
use Hash;
use Illuminate\Http\Request;
use Illuminate\support\Collection;
use Input;
use Lang;
use Mail;
use PDF;
use UTC;

/**
 * TicketController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type response
     */
    public function __construct(PhpMailController $PhpMailController, Notify $NotificationController)
    {
        $this->PhpMailController = $PhpMailController;
        $this->NotificationController = $NotificationController;
        $this->middleware('auth');
    }

    /**
     * Show the Inbox ticket list page.
     *
     * @return type response
     */
    public function inbox_ticket_list()
    {
        return view('themes.default1.agent.helpdesk.ticket.inbox');
    }

    public function get_inbox()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::whereIn('status', [1, 7])->get();
        } else {
            $dept = DB::table('department')->where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::whereIn('status', [1, 7])->where('dept_id', '=', $dept->id)->orWhere('assigned_to', '=', Auth::user()->id)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * Show the Open ticket list page.
     *
     * @return type response
     */
    public function open_ticket_list()
    {
        return view('themes.default1.agent.helpdesk.ticket.open');
    }

    public function get_open()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * Show the answered ticket list page.
     *
     * @return type response
     */
    public function answered_ticket_list()
    {
        return view('themes.default1.agent.helpdesk.ticket.answered');
    }

    public function get_answered()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', 1)->where('isanswered', '=', 1)->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '=', 1)->where('isanswered', '=', 1)->where('dept_id', '=', $dept->id)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * Show the Myticket list page.
     *
     * @return type response
     */
    public function myticket_ticket_list()
    {
        return view('themes.default1.agent.helpdesk.ticket.myticket');
    }

    public function get_myticket()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', 1)->where('assigned_to', '=', Auth::user()->id)->get();
        } else {
            $tickets = Tickets::where('status', '=', 1)->where('assigned_to', '=', Auth::user()->id)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * Show the Overdue ticket list page.
     *
     * @return type response
     */
    public function overdue_ticket_list()
    {
        return view('themes.default1.agent.helpdesk.ticket.overdue');
    }

    /**
     * Ajax response overdue tickets.
     *
     * @return type json
     */
    public function getOverdueTickets()
    {
        if (Auth::user()->role == 'agent') {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $overdues = Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->orderBy('id', 'DESC')->get();
        } else {
            $overdues = Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->orderBy('id', 'DESC')->get();
        }
        if (count($overdues) == 0) {
            $tickets = null;
        } else {
            $i = 0;
            foreach ($overdues as $overdue) {
                $sla_plan = Sla_plan::where('id', '=', $overdue->sla)->first();

                $ovadate = $overdue->created_at;
                $new_date = date_add($ovadate, date_interval_create_from_date_string($sla_plan->grace_period)).'<br/><br/>';
                if (date('Y-m-d H:i:s') > $new_date) {
                    $i++;
                    $value[] = $overdue;
                }
            }
            // dd(count($value));
            if ($i > 0) {
                $tickets = new collection($value);
            } else {
                $tickets = null;
            }
        }

        return $this->getTable($tickets);
    }

    /**
     * Show the Open ticket list page.
     *
     * @return type response
     */
    public function dueTodayTicketlist()
    {
        $ldate = date('Y-m-d');

        return view('themes.default1.agent.helpdesk.ticket.duetodayticket');
    }

    public function getDueToday()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', 1)->whereRaw('date(duedate) = ?', [date('Y-m-d')])->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '=', 1)->whereRaw('date(duedate) = ?', [date('Y-m-d')])->where('dept_id', '=', $dept->id)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * Show the Closed ticket list page.
     *
     * @return type response
     */
    public function closed_ticket_list()
    {
        return view('themes.default1.agent.helpdesk.ticket.closed');
    }

    public function get_closed()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '>', 1)->where('status', '<', 4)->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '>', 1)->where('dept_id', '=', $dept->id)->where('status', '<', 4)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * Show the ticket list page.
     *
     * @return type response
     */
    public function assigned_ticket_list()
    {
        return view('themes.default1.agent.helpdesk.ticket.assigned');
    }

    public function get_assigned()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', 1)->where('assigned_to', '>', 0)->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '=', 1)->where('assigned_to', '>', 0)->where('dept_id', '=', $dept->id)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * Show the New ticket page.
     *
     * @return type response
     */
    public function newticket(CountryCode $code)
    {
        
        $assignto_agent=User::where('role', '!=', 'user')->where('primary_dpt','=',1)->get();
        
        $location = GeoIP::getLocation();
        $phonecode = $code->where('iso', '=', $location->iso_code)->first();
        $settings = CommonSettings::select('status')->where('option_name', '=', 'send_otp')->first();
        $email_mandatory = CommonSettings::select('status')->where('option_name', '=', 'email_mandatory')->first();

        return view('themes.default1.agent.helpdesk.ticket.new', compact('assignto_agent','email_mandatory', 'settings'))->with('phonecode', $phonecode->phonecode);
    }


     public function newticket1(CountryCode $code,Request $request)
    {   


        $depertment_id=$request->helptopic;
        $dept_id=Department::select('id')->where('id','=',$depertment_id)->first();
        $assignto_agent = User::select('id','first_name')->where('role', '!=', 'user')->where('primary_dpt','=',$dept_id->id)->get();
        $teams = Teams::where('status', '=', '1')->get();
        $count_teams = count($teams);
        $html = "";
        foreach ($assignto_agent as  $agent) {
             
                $html .= "<option value='user_".$agent->id."'>".$agent->first_name."</option>";
            
        
        }
        // team_{{$team->id}}
        $html1 = "";
        foreach ($teams as  $team) {
           $html1 .=  "<option value='team_".$team->id."'>".$team->name."</option>";
        }

        echo $html,$html1;
        
    }

    /**
     * Save the data of new ticket and show the New ticket page with result.
     *
     * @param type CreateTicketRequest $request
     *
     * @return type response
     */
    public function post_newticket(CreateTicketRequest $request, CountryCode $code, $api = false)
    {

       //  $ticket_assign = Input::get('assignto');
       //  $assignto = explode('_', $ticket_assign);
        

       //  if ($assignto[0] == 'team') {
       //      // $ticket->team_id = $assignto[1];
       //      $team_detail = Teams::where('id', '=', $assignto[1])->first();
       //      $assignee = $team_detail->name;

           
       //  } elseif ($assignto[0] == 'user') {
       //      // $ticket->assigned_to = $assignto[1];
       //      $user_detail = User::where('id', '=', $assignto[1])->first();
       //      $assignee = $user_detail->first_name.' '.$user_detail->last_name;
            
       // }
       //  dd('oooooooooo');
        try {
            if ($request->input('email')) {
                $email = $request->input('email');
            } else {
                $email = null;
            }
            $fullname = $request->input('first_name').'%$%'.$request->input('last_name');
            $helptopic = $request->input('helptopic');
            $sla = $request->input('sla');
            $duedate = $request->input('duedate');

        $ticket_assign =$request->input('assignto');
        $assignto = explode('_', $ticket_assign);
        
// dd('okkkk');
        if ($assignto[0] == 'team') {
            $team_id = $assignto[1];
              $assigned_to = null;
            // $team_detail = Teams::where('id', '=', $assignto[1])->first();
            // $assignee = $team_detail->name;

           
        } elseif ($assignto[0] == 'user') {
            $assigned_to = $assignto[1];
            $team_id= null;
            // $user_detail = User::where('id', '=', $assignto[1])->first();
            // $assignee = $user_detail->first_name.' '.$user_detail->last_name;
            
       }
       else {
                // $assigned_to = null;
            }




// dd($team_id);

         // if ($request->input('assignto')) {
         //        $assignto = $request->input('assignto');
         //    } else {
         //        $assignto = null;
         //    }
            $subject = $request->input('subject');
            $body = $request->input('body');
            $priority = $request->input('priority');
            $phone = $request->input('phone');
            $phonecode = $request->input('code');
            if ($request->input('mobile')) {
                $mobile_number = $request->input('mobile');
            } else {
                $mobile_number = null;
            }
            $source = Ticket_source::where('name', '=', 'agent')->first();
            $headers = null;
            $help = Help_topic::where('id', '=', $helptopic)->first();
            $form_data = null;
            $auto_response = 0;
            $status = 1;
            if ($phone != null || $mobile_number != null) {
                $location = GeoIP::getLocation();
                $geoipcode = $code->where('iso', '=', $location->iso_code)->first();
                if ($phonecode == null) {
                    $data = [
                        'fails'              => Lang::get('lang.country-code-required-error'),
                        'phonecode'          => $geoipcode->phonecode,
                        'country_code_error' => 1,
                    ];
                    if ($api != false) {
                        return $data;
                    }

                    return Redirect()->back()->with($data)->withInput($request->except('password'));
                } else {
                    $code = CountryCode::select('phonecode')->where('phonecode', '=', $phonecode)->get();
                    if (!count($code)) {
                        $data = [
                            'fails'              => Lang::get('lang.incorrect-country-code-error'),
                            'phonecode'          => $geoipcode->phonecode,
                            'country_code_error' => 1,
                        ];
                        if ($api != false) {
                            return $data;
                        }

                        return Redirect()->back()->with($data)->withInput($request->except('password'));
                    }
                }
            }
            //create user
            $result = $this->create_user($email, $fullname, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source->id, $headers, $help->department,$assigned_to,$team_id, $form_data, $auto_response, $status);
            if ($result[1]) {
                $status = $this->checkUserVerificationStatus();
                if ($status == 1) {
                    if ($api != false) {
                        return Lang::get('lang.Ticket-created-successfully');
                    }

                    return Redirect('newticket')->with('success', Lang::get('lang.Ticket-created-successfully'));
                } else {
                    if ($api != false) {
                        return Lang::get('lang.Ticket-created-successfully');
                    }

                    return Redirect('newticket')->with('success', Lang::get('lang.Ticket-created-successfully2'));
                }
            } else {
                if ($api != false) {
                    return Lang::get('lang.failed-to-create-user-tcket-as-mobile-has-been-taken');
                }

                return Redirect('newticket')->with('fails', Lang::get('lang.failed-to-create-user-tcket-as-mobile-has-been-taken'))->withInput($request->except('password'));
            }
        } catch (Exception $e) {
            // dd($e);
            if ($api != false) {
                return $e->getMessage();
            }

            return Redirect()->back()->with('fails', '<li>'.$e->getMessage().'</li>');
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
        if (Auth::user()->role == 'agent') {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('id', '=', $id)->first();
            if ($tickets->dept_id == $dept->id) {
                $tickets = $tickets;
            } elseif ($tickets->assigned_to == Auth::user()->id) {
                $tickets = $tickets;
            } else {
                $tickets = null;
            }
//            $tickets = $tickets->where('dept_id', '=', $dept->id)->orWhere('assigned_to', Auth::user()->id)->first();
//            dd($tickets);
        } elseif (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('id', '=', $id)->first();
        } elseif (Auth::user()->role == 'user') {
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

        return view('themes.default1.agent.helpdesk.ticket.timeline', compact('tickets', 'max_size_in_bytes', 'max_size_in_actual', 'tickets_approval'), compact('thread', 'avg_rating'));
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
    public function reply(Ticket_Thread $thread, Request $request, Ticket_attachments $ta, $mail = true, $system_reply = true, $user_id = '')
    {
        //dd($request->all());
        if (is_array($request->file('attachment'))) {
        } else {
            try {
                $size = $this->size();
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }

        $fileupload = new FileuploadController();
        $fileupload = $fileupload->file_upload_max_size();
        $max_size_in_bytes = $fileupload[0];
        $max_size_in_actual = $fileupload[1];

        $attachments = $request->file('attachment');
        $check_attachment = null;
        // Event fire
        $eventthread = $thread->where('ticket_id', $request->input('ticket_ID'))->first();
        //dd($eventthread);

        $eventuserid = $eventthread->user_id;
        $emailadd = User::where('id', $eventuserid)->first()->email;
        $source = $eventthread->source;
        $form_data = $request->except('reply_content', 'ticket_ID', 'attachment');
        \Event::fire(new \App\Events\ClientTicketFormPost($form_data, $emailadd, $source));
        $reply_content = $request->input('reply_content');

        $thread->ticket_id = $request->input('ticket_ID');
        $thread->poster = 'support';
        $thread->body = $request->input('reply_content');
        if ($system_reply == true) {
            $thread->user_id = Auth::user()->id;
        } else {
            $thread->user_id = $eventuserid;
            if ($user_id !== '') {
                $thread->user_id = $user_id;
            }
        }
        $ticket_id = $request->input('ticket_ID');

        $tickets = Tickets::where('id', '=', $ticket_id)->first();
        $tickets->isanswered = '1';
        $tickets->save();

        $ticket_user = User::where('id', '=', $tickets->user_id)->first();
        if ($system_reply == true) {
            if ($tickets->assigned_to == 0) {
                $tickets->assigned_to = Auth::user()->id;
                $tickets->save();
                $thread2 = new Ticket_Thread();
                $thread2->ticket_id = $thread->ticket_id;
                $thread2->user_id = Auth::user()->id;
                $thread2->is_internal = 1;
                $thread2->body = 'This Ticket have been assigned to '.Auth::user()->first_name.' '.Auth::user()->last_name;
                $thread2->save();
                $data = [
                    'id' => $tickets->id,
                ];
                \Event::fire('ticket-assignment', [$data]);
            }
            if ($tickets->status > 1) {
                $this->open($ticket_id, new Tickets());
            }
        }
        $thread->save();

        if ($attachments != null) {
            foreach ($attachments as $attachment) {
                if ($attachment != null) {
                    $name = $attachment->getClientOriginalName();
                    $type = $attachment->getClientOriginalExtension();
                    $size = $attachment->getSize();
                    $data = file_get_contents($attachment->getRealPath());
                    $attachPath = $attachment->getRealPath();
                    $ta->create(['thread_id' => $thread->id, 'name' => $name, 'size' => $size, 'type' => $type, 'file' => $data, 'poster' => 'ATTACHMENT']);
                    $check_attachment = 1;
                } else {
                    $check_attachment = null;
                }
            }
        }

        if ($check_attachment == 1) {
            $attachment_files = $this->attachmentSeperate($thread->id);
        } else {
            $attachment_files = null;
        }

        $thread = Ticket_Thread::where('ticket_id', '=', $ticket_id)->orderBy('id')->first();
        $ticket_subject = $thread->title;
        $user_id = $tickets->user_id;
        $user = User::where('id', '=', $user_id)->first();
        $email = $user->email;
        $user_name = $user->first_name;
        $ticket_number = $tickets->ticket_number;
        $company = $this->company();
        $username = $ticket_user->first_name;
        if (!empty(Auth::user()->agent_sign)) {
            $agentsign = Auth::user()->agent_sign;
        } else {
            $agentsign = null;
        }

        // Event
        \Event::fire(new \App\Events\FaveoAfterReply($reply_content, $user->mobile, $user->country_code, $request, $tickets));
        if (Auth::user()) {
            $u_id = Auth::user()->first_name.' '.Auth::user()->last_name;
        } else {
            $u_id = $this->getAdmin()->first_name.' '.$this->getAdmin()->last_name;
        }
        $data = [
            'ticket_id' => $request->input('ticket_ID'),
            'u_id'      => $u_id,
            'body'      => $request->input('reply_content'),
        ];
        if (!$request->has('do-not-send')) {
            \Event::fire('Reply-Ticket', [$data]);
        }
        // sending attachments via php mail function
        $message = '';

        $collaborators = Ticket_Collaborator::where('ticket_id', '=', $ticket_id)->get();

        $emails = Emails::where('department', '=', $tickets->dept_id)->first();
        if (!$email) {
            $mail = false;
        }
        try {
            if ($mail == true) {
                $this->NotificationController->create($ticket_id, Auth::user()->id, '2');
                $this->PhpMailController->sendmail(
                        $from = $this->PhpMailController->mailfrom('0', $tickets->dept_id), $to = ['name' => $user_name, 'email' => $email, 'cc' => $collaborators], $message = ['subject' => $ticket_subject.'[#'.$ticket_number.']', 'body' => $request->input('reply_content'), 'scenario' => 'ticket-reply', 'attachments' => $attachment_files], $template_variables = ['ticket_number' => $ticket_number, 'user' => $username, 'agent_sign' => $agentsign]
                );
            }
        } catch (\Exception $e) {
            //dd($e->getMessage());
            return 0;
        }

        return 1;
    }

    /**
     * Ticket edit and save ticket data.
     *
     * @param type               $ticket_id
     * @param type Ticket_Thread $thread
     *
     * @return type bool
     */
    public function ticketEditPost($ticket_id, Ticket_Thread $thread, Tickets $ticket)
    {
        if (Input::get('subject') == null) {
            return 1;
        } elseif (Input::get('sla_paln') == null) {
            return 2;
        } elseif (Input::get('help_topic') == null) {
            return 3;
        } elseif (Input::get('ticket_source') == null) {
            return 4;
        } elseif (Input::get('ticket_priority') == null) {
            return 5;
        } else {
            $ticket = $ticket->where('id', '=', $ticket_id)->first();
            $ticket->sla = Input::get('sla_paln');
            $ticket->help_topic_id = Input::get('help_topic');
            $ticket->source = Input::get('ticket_source');
            $ticket->priority_id = Input::get('ticket_priority');
            $dept = Help_topic::select('department')->where('id', '=', $ticket->help_topic_id)->first();
            $ticket->dept_id = $dept->department;
            $ticket->save();

            $threads = $thread->where('ticket_id', '=', $ticket_id)->first();
            $threads->title = Input::get('subject');
            $threads->save();

            return 0;
        }
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
        $tickets = Tickets::where('id', '=', $id)->first();
        $thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
        $html = view('themes.default1.agent.helpdesk.ticket.pdf', compact('id', 'tickets', 'thread'))->render();
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
    public function create_user($emailadd, $username, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $headers, $dept, $assigned_to,$team_id, $from_data, $auto_response, $status)
    {
        // define global variables
        $email;
        $username;
        $unique = $emailadd;
        if (!$emailadd) {
            $unique = $mobile_number;
        }
        // check emails
        $ticket_creator = $username;
        $checkemail = $this->checkEmail($unique);
        $company = $this->company();
        if ($checkemail == false) {
            if ($mobile_number != '' || $mobile_number != null) {
                $check_mobile = $this->checkMobile($mobile_number);
                if ($check_mobile == true) {
                    return ['0' => 'not available', '1' => false];
                }
            }
            // Generate password
            $password = $this->generateRandomString();
            // create user
            $user = new User();
            $user_name_123 = explode('%$%', $username);
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
            $user->remember_token = $token;
            // mail user his/her password
            \Event::fire(new \App\Events\ClientTicketFormPost($from_data, $emailadd, $source));
            if ($user->save()) {
                $user_id = $user->id;
                $email_mandatory = CommonSettings::select('status')->where('option_name', '=', 'email_mandatory')->first();
                if ($user_status == 0 || ($email_mandatory->status == 0 || $email_mandatory->status == '0')) {
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
                try {
                    if ($auto_response == 0) {
                        $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $user->first_name, 'email' => $emailadd], $message = ['subject' => null, 'scenario' => 'registration-notification'], $template_variables = ['user' => $user->first_name, 'email_address' => $emailadd, 'user_password' => $password]);
                        if ($user_status == 0) {
                            $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $user->first_name, 'email' => $emailadd], $message = ['subject' => null, 'scenario' => 'registration'], $template_variables = ['user' => $user->first_name, 'email_address' => $emailadd, 'password_reset_link' => url('account/activate/'.$token)]);
                        }
                    }
                } catch (\Exception $e) {
                    //dd($e);
                }
            }
        } else {
            $username = $checkemail->first_name;
            $user_id = $checkemail->id;
        }
        $ticket_number = $this->check_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assigned_to,$team_id, $from_data, $status);

        $ticket_number2 = $ticket_number[0];
        $ticketdata = Tickets::where('ticket_number', '=', $ticket_number2)->first();
        $threaddata = Ticket_Thread::where('ticket_id', '=', $ticketdata->id)->first();
        $is_reply = $ticket_number[1];
        //dd($source);
        $system = $this->system();
        $updated_subject = $threaddata->title.'[#'.$ticket_number2.']';
        if ($ticket_number2) {
            // send ticket create details to user
            if ($is_reply == 0) {
                $mail = 'create-ticket-agent';
                if (Auth::user()) {
                    $sign = Auth::user()->agent_sign;
                } else {
                    $sign = $company;
                }
                if ($source == 3) {
                    try {
                        if ($auto_response == 0) {
                            //dd($source);
                            $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticketdata->dept_id), $to = ['name' => $username, 'email' => $emailadd], $message = ['subject' => $updated_subject, 'scenario' => 'create-ticket-by-agent', 'body' => $body], $template_variables = ['agent_sign' => Auth::user()->agent_sign, 'ticket_number' => $ticket_number2]);
                        }
                    } catch (\Exception $e) {
                    }
                } else {
                    $body2 = null;
                    try {
                        if ($auto_response == 0) {
                            $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticketdata->dept_id), $to = ['name' => $username, 'email' => $emailadd], $message = ['subject' => $updated_subject, 'scenario' => 'create-ticket'], $template_variables = ['user' => $username, 'ticket_number' => $ticket_number2, 'department_sign' => '']);
                        }
                    } catch (\Exception $e) {
                    }
                }
            } elseif ($is_reply == 1) {
                $mail = 'ticket-reply-agent';
            }
            $set_mails = [];
            if (Alert::first()->ticket_status == 1 || Alert::first()->ticket_admin_email == 1) {
                // send email to admin
                $admins = User::where('role', '=', 'admin')->get();
                foreach ($admins as $admin) {
                    $to_email = $admin->email;
                    $to_user = $admin->first_name;
                    $to_user_name = $admin->first_name;
                    array_push($set_mails, ['to_email' => $to_email, 'to_user' => $to_user, 'to_user_name' => $to_user_name]);
                }
            }

            if ($is_reply == 0) {
                if (Alert::first()->ticket_status == 1 || Alert::first()->ticket_department_member == 1) {
                    // send email to agents
                    $agents = User::where('role', '=', 'agent')->get();
                    foreach ($agents as $agent) {
                        $department_data = Department::where('id', '=', $ticketdata->dept_id)->first();

                        if ($department_data->name == $agent->primary_dpt) {
                            $to_email = $agent->email;
                            $to_user = $agent->first_name;
                            $to_user_name = $agent->first_name;
                            array_push($set_mails, ['to_email' => $to_email, 'to_user' => $to_user, 'to_user_name' => $to_user_name]);
                        }
                    }
                }
//                Event fire for new ticket['']
            }

            if ($ticketdata->assigned_to) {
                $assigned_to = User::where('id', '=', $ticketdata->assigned_to)->first();
                $to_email = $assigned_to->email;
                $to_user = $assigned_to->first_name;
                $to_user_name = $assigned_to->first_name;
                array_push($set_mails, ['to_email' => $to_email, 'to_user' => $to_user, 'to_user_name' => $to_user_name]);
            }
            $emails_to_be_sent = array_unique($set_mails, SORT_REGULAR);
            foreach ($emails_to_be_sent as $email_data) {
                try {
                    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticketdata->dept_id), $to = ['user' => $email_data['to_user'], 'email' => $email_data['to_email']], $message = ['subject' => $updated_subject, 'body' => $body, 'scenario' => $mail], $template_variables = ['ticket_agent_name' => $email_data['to_user_name'], 'ticket_client_name' => $username, 'ticket_client_email' => $emailadd, 'user' => $email_data['to_user_name'], 'ticket_number' => $ticket_number2, 'email_address' => $emailadd, 'name' => $ticket_creator]);
                } catch (\Exception $e) {
                    // dd($e);
                }
            }
            $data = [
                'ticket_number' => $ticket_number2,
                'user_id'       => $user_id,
                'subject'       => $subject,
                'body'          => $body,
                'status'        => $status,
                'Priority'      => $priority,
            ];
            \Event::fire('Create-Ticket', [$data]);
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
    public function check_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept,  $assigned_to,$team_id, $form_data, $status)
    {
        $read_ticket_number = explode('[#', $subject);
        if (isset($read_ticket_number[1])) {
            $separate = explode(']', $read_ticket_number[1]);
            $new_subject = substr($separate[0], 0, 20);
            $find_number = Tickets::where('ticket_number', '=', $new_subject)->first();
            $thread_body = explode('---Reply above this line---', $body);
            $body = $thread_body[0];
            if (count($find_number) > 0) {
                $id = $find_number->id;
                $ticket_number = $find_number->ticket_number;
                if ($find_number->status > 1) {
                    $find_number->status = 1;
                    $find_number->closed = 0;
                    $find_number->closed_at = date('Y-m-d H:i:s');
                    $find_number->reopened = 1;
                    $find_number->reopened_at = date('Y-m-d H:i:s');
                    $find_number->save();

                    $ticket_status = Ticket_Status::where('id', '=', 1)->first();

                    $user_name = User::where('id', '=', $user_id)->first();

                    if ($user_name->role == 'user') {
                        $username = $user_name->user_name;
                    } elseif ($user_name->role == 'agent' or $user_name->role == 'admin') {
                        $username = $user_name->first_name.' '.$user_name->last_name;
                    }

                    $ticket_threads = new Ticket_Thread();
                    $ticket_threads->ticket_id = $id;
                    $ticket_threads->user_id = $user_id;
                    $ticket_threads->is_internal = 1;
                    $ticket_threads->body = $ticket_status->message.' '.$username;
                    $ticket_threads->save();
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
                    if ($this->ticketThread($subject, $body, $id, $user_id)) {
                        //                        event fire for reply [$subject, $body, $id, $user_id]
                        return [$ticket_number, 1];
                    }
                }
            } else {
                $ticket_number = $this->createTicket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept,  $assigned_to,$team_id, $form_data, $status);

                return [$ticket_number, 0];
            }
        } else {
            $ticket_number = $this->createTicket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assigned_to,$team_id, $form_data, $status);

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
    public function createTicket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assigned_to,$team_id, $form_data, $status)
    {
        // dd($dept);
        $ticket_number = '';
        $max_number = Tickets::whereRaw('id = (select max(`id`) from tickets)')->first();
        if ($max_number) {
            $ticket_number = $max_number->ticket_number;
        }
        // dd($ticket_number);

        $user_status = User::select('active')->where('id', '=', $user_id)->first();
        
        $ticket = new Tickets();
        // $ticket->ticket_number=$ticket_number;
        $ticket->ticket_number = $this->ticketNumber($ticket_number);
        // dd('ppppppppppp');
        $ticket->user_id = $user_id;
        $ticket->dept_id = $dept;
        $ticket->help_topic_id = $helptopic;
        $ticket->sla = $sla;

        $ticket->assigned_to = $assigned_to;
       
        $ticket->team_id=$team_id;

        $ticket->priority_id = $priority;
        $ticket->source = $source;
     
        $ticket_status = $this->checkUserVerificationStatus();
        
        if ($ticket_status == 0) {
            //check if user active then allow ticket creation else create unverified ticket
            if ($user_status->active == 1) {
                if ($status == null) {
                    $ticket->status = 1;
                } else {
                    $ticket->status = $status;
                }
            } else {
                $ticket->status = 6;
            }
        } else {
            if ($status == null) {
                $ticket->status = 1;
            } else {
                $ticket->status = $status;
            }
        }
        $ticket->save();

        $sla_plan = Sla_plan::where('id', '=', $sla)->first();
        $ovdate = $ticket->created_at;
        $new_date = date_add($ovdate, date_interval_create_from_date_string($sla_plan->grace_period));
        $ticket->duedate = $new_date;
        $ticket->save();

        $ticket_number = $ticket->ticket_number;
        $id = $ticket->id;
        $this->NotificationController->create($id, $user_id, '3');
        // store Form Data
        // Form Data comes from raising a ticket from client panel
        if ($form_data != null) {
            $help_topic = Help_topic::where('id', '=', $helptopic)->first();
            //$forms = Fields::where('forms_id', '=', $help_topic->custom_form)->get();
            $form = \App\Model\helpdesk\Form\Forms::find($help_topic->custom_form);
            $form_name = '';
            if ($form) {
                $form_name = $form->formname;
            }
            foreach ($form_data as $key => $form_details) {
                if (!is_array($form_details)) {
                    $form_value = new Ticket_Form_Data();
                    $form_value->ticket_id = $id;
                    $form_value->title = $key;
                    $form_value->content = $form_details;
                    $form_value->save();
                }
            }
        }
        // store collaborators
        $this->storeCollaborators($headers, $id);
        if ($this->ticketThread($subject, $body, $id, $user_id) == true) {
            return $ticket_number;
        }
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
    public function ticketThread($subject, $body, $id, $user_id)
    {
        $thread = new Ticket_Thread();
        $thread->user_id = $user_id;
        $thread->ticket_id = $id;
        $thread->poster = 'client';
        $thread->title = $subject;
        $thread->body = $body;
        if ($thread->save()) {
            \Event::fire('ticket.details', ['ticket' => $thread]); //get the ticket details
            return true;
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
    public function close($id, Tickets $ticket)
    {
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
        if (\Auth::user()->role == 'user') {
            $is_internal = 0;
        } else {
            $is_internal = 1;
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
        $thread->is_internal = $is_internal;
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
            $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticket_status->dept_id), $to = ['name' => $user_name, 'email' => $email], $message = ['subject' => $ticket_subject.'[#'.$ticket_number.']', 'scenario' => 'close-ticket'], $template_variables = ['ticket_number' => $ticket_number]);
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
    public function resolve($id, Tickets $ticket)
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
    public function delete($id, Tickets $ticket)
    {
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
    public function ban($id, Tickets $ticket)
    {
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
    public function assign($id)
    {
        $UserEmail = Input::get('assign_to');
        $assign_to = explode('_', $UserEmail);
        $ticket = Tickets::where('id', '=', $id)->first();
dd($UserEmail);
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
            $user_detail = User::where('id', '=', $assign_to[1])->first();
            $assignee = $user_detail->first_name.' '.$user_detail->last_name;

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
                $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticket->dept_id), $to = ['name' => $agent, 'email' => $agent_email], $message = ['subject' => $ticket_subject.'[#'.$ticket_number.']', 'scenario' => 'assign-ticket'], $template_variables = ['ticket_agent_name' => $agent, 'ticket_number' => $ticket_number, 'ticket_assigner' => $master, 'ticket_link' => $ticket_link]);
            } catch (\Exception $e) {
                return 0;
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
        $InternalContent = Input::get('InternalContent');
        $thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
        $NewThread = new Ticket_Thread();
        $NewThread->ticket_id = $thread->ticket_id;
        $NewThread->user_id = Auth::user()->id;
        $NewThread->is_internal = 1;
        $NewThread->poster = Auth::user()->role;
        $NewThread->title = $thread->title;
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
        $company = $this->company();
        if (isset($headers)) {
            foreach ($headers as $email => $name) {
                if ($name == null) {
                    $name = $email;
                }
                $name = $name;
                $email = $email;
                if ($this->checkEmail($email) == false) {
                    $create_user = new User();
                    $create_user->first_name = $name;
                    $create_user->user_name = $email;
                    $create_user->email = $email;
                    $create_user->active = 1;
                    $create_user->role = 'user';
                    $password = $this->generateRandomString();
                    $create_user->password = Hash::make($password);
                    $create_user->save();
                    $user_id = $create_user->id;
                    try {
                        $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $email], $message = ['subject' => 'password', 'scenario' => 'registration-notification'], $template_variables = ['user' => $name, 'email_address' => $email, 'user_password' => $password]);
                    } catch (\Exception $e) {
                    }
                } else {
                    $user = $this->checkEmail($email);
                    $user_id = $user->id;
                }
                $collaborator_store = new Ticket_Collaborator();
                $collaborator_store->isactive = 1;
                $collaborator_store->ticket_id = $id;
                $collaborator_store->user_id = $user_id;
                $collaborator_store->role = 'ccc';
                $collaborator_store->save();
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
        return view('themes.default1.agent.helpdesk.ticket.trash');
    }

    public function get_trash()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', 5)->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '=', 5)->where('dept_id', '=', $dept->id)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * shows unassigned tickets.
     *
     * @return type
     */
    public function unassigned()
    {
        return view('themes.default1.agent.helpdesk.ticket.unassigned');
    }

    public function get_unassigned()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('assigned_to', '=', null)->where('status', '1')->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('assigned_to', '=', null)->where('status', '1')->where('dept_id', '=', $dept->id)->get();
        }

        return $this->getTable($tickets);
    }

    /**
     * shows tickets assigned to Auth::user().
     *
     * @return type
     */
    public function myticket()
    {
        return view('themes.default1.agent.helpdesk.ticket.myticket');
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
        $user = \App\User::where('email', 'LIKE', '%'.$term.'%')->lists('email');
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
        $user = $user->lists('email');
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

                $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $email], $message = ['subject' => 'Password', 'scenario' => 'registration-notification'], $template_variables = ['user' => $name, 'email_address' => $email, 'user_password' => $password]);
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
                return view('themes.default1.agent.helpdesk.dept-ticket.open', compact('id'));
            } else {
                return redirect()->back()->with('fails', 'Unauthorised!');
            }
        } else {
            return view('themes.default1.agent.helpdesk.dept-ticket.open', compact('id'));
        }
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
            if (Alert::first()->internal_status == 1 || Alert::first()->internal_assigned_agent == 1) {
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
                    'name'       => $name, ], ['email'       => 'required|email',
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
                    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $email], $message = ['subject' => 'Password', 'scenario' => 'registration-notification'], $template_variables = ['user' => $name, 'email_address' => $email, 'user_password' => $password]);
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
            $p_id = Input::get('p_id');
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
        return \Datatable::collection(new Collection($tickets))
                        ->addColumn('id', function ($ticket) {
                            return "<input type='checkbox' name='select_all[]' id='".$ticket->id."' onclick='someFunction(this.id)' class='selectval icheckbox_flat-blue' value='".$ticket->id."'></input>";
                        })
                        ->addColumn('subject', function ($ticket) {
                            $subject = Ticket_Thread::where('ticket_id', '=', $ticket->id)->orderBy('id')->first();
                            if (isset($subject->title)) {
                                $string = str_limit($subject->getSubject(), 20);
                            } else {
                                $string = '(no subject)';
                            }
                            //collabrations
                            $collaborators = DB::table('ticket_collaborator')->where('ticket_id', '=', $ticket->id)->get();
                            $collab = count($collaborators);
                            if ($collab > 0) {
                                $collabString = '&nbsp;<i class="fa fa-users"></i>';
                            } else {
                                $collabString = null;
                            }
                            $threads = Ticket_Thread::where('ticket_id', '=', $ticket->id)->first(); //
                            $count = Ticket_Thread::where('ticket_id', '=', $ticket->id)->count(); //
                            if ($threads != null) {
                                $attachment = Ticket_attachments::where('thread_id', '=', $threads->id)->get();
                                $attachCount = count($attachment);
                            } else {
                                $attachCount = 0;
                            }
                            if ($attachCount > 0) {
                                $attachString = '&nbsp;<i class="fa fa-paperclip"></i>';
                            } else {
                                $attachString = '';
                            }
                            $css = $ticket->sourceCss();
                            $titles = '';
                            if ($subject) {
                                $titles = $subject->getSubject();
                            }

                            return "<a href='".route('ticket.thread', [$ticket->id])."' title='".$titles."'>".ucfirst($string)."&nbsp;<span style='color:green'>(".$count.")<i class='".$css."'></i></span></a>".$collabString.$attachString;
                        })
                        ->addColumn('ticket_number', function ($ticket) {
                            return "<a href='".route('ticket.thread', [$ticket->id])."' title='".$ticket->ticket_number."'>#".$ticket->ticket_number.'</a>';
                        })
                        ->addColumn('priority', function ($ticket) {
                            $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->where('is_internal', '=', 0)->max('id');
                            $TicketDatarow = Ticket_Thread::where('id', '=', $TicketData)->first();
                            $rep = '#000';
                            $username = '';
                            if ($TicketDatarow) {
                                $LastResponse = User::where('id', '=', $TicketDatarow->user_id)->first();
                                if ($LastResponse) {
                                    if ($LastResponse->role == 'user') {
                                        $rep = '#F39C12';
                                        $username = $LastResponse->user_name;
                                    } else {
                                        $rep = '#000';
                                        $username = $LastResponse->first_name.' '.$LastResponse->last_name;
                                        if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                            $username = $LastResponse->user_name;
                                        }
                                    }
                                }
                            }
                            $priority = DB::table('ticket_priority')->select('priority_desc', 'priority_color')->where('priority_id', '=', $ticket->priority_id)->first();
                            if ($priority != null) {
                                $prio = '<button class="btn btn-xs '.$rep.'" style="background-color: '.$priority->priority_color.'; color:#F9F9F9">'.ucfirst($priority->priority_desc).'</button>';
                            } else {
                                $prio = '';
                            }

                            return $prio;
                        })
                        ->addColumn('from', function ($ticket) {
                            $from = DB::table('users')->select('user_name', 'first_name', 'last_name')->where('id', '=', $ticket->user_id)->first();
                            $url = route('user.show', $ticket->user_id);
                            $name = '';
                            if ($from) {
                                if ($from->first_name) {
                                    $name = $from->first_name.' '.$from->last_name;
                                } else {
                                    $name = $from->user_name;
                                }
                            }

                            return "<a href='".$url."' title='".Lang::get('lang.see-profile1').' '.ucfirst($from->user_name).'&apos;'.Lang::get('lang.see-profile2')."'><span style='color:#508983'>".ucfirst(str_limit($name, 30)).'</span></a>';
                        })
                        // ->addColumn('Last Replier', function ($ticket) {
                        //     $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->where('is_internal', '=', 0)->max('id');
                        //     $TicketDatarow = Ticket_Thread::where('id', '=', $TicketData)->first();
                        //     $LastResponse = User::where('id', '=', $TicketDatarow->user_id)->first();
                        //     if ($LastResponse->role == 'user') {
                        //         $rep = '#F39C12';
                        //         $username = $LastResponse->user_name;
                        //     } else {
                        //         $rep = '#000';
                        //         $username = $LastResponse->first_name.' '.$LastResponse->last_name;
                        //         if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                        //             $username = $LastResponse->user_name;
                        //         }
                        //     }
                        //     return "<a href='' title=''><span style='color:".$rep."'>".ucfirst($username).'</span></a>';
                        // })
                        ->addColumn('assigned_to', function ($ticket) {
                            if ($ticket->assigned_to == null && $ticket->team_id == null) {
                                return "<span style='color:red'>Unassigned</span>";
                            } elseif($ticket->team_id != null){
                                $assign = DB::table('teams')->where('id', '=', $ticket->team_id)->first();
                                $url = route('user.show', $ticket->team_id);
                                 // return "$assign->name";
                                 return "<a href='".$url."' title='".Lang::get('lang.see-profile1').' '.ucfirst($assign->name).'&apos;'.Lang::get('lang.see-profile2')."'><span style='color:green'>".ucfirst($assign->name).'</span></a>';

                            } 
                            else{
                                $assign = DB::table('users')->where('id', '=', $ticket->assigned_to)->first();
                                $url = route('user.show', $ticket->assigned_to);

                                return "<a href='".$url."' title='".Lang::get('lang.see-profile1').' '.ucfirst($assign->first_name).'&apos;'.Lang::get('lang.see-profile2')."'><span style='color:green'>".ucfirst($assign->first_name).' '.ucfirst($assign->last_name).'</span></a>';
                            }
                        })
                        ->addColumn('Last', function ($ticket) {
                            $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
                            $TicketDatarow = Ticket_Thread::select('updated_at')->where('id', '=', $TicketData)->first();
                            $updated = '--';
                            if ($TicketDatarow) {
                                $updated = $TicketDatarow->updated_at;
                            }

                            return '<span style="display:none">'.$updated.'</span>'.UTC::usertimezone($updated);
                        })
                        ->searchColumns('subject', 'from', 'assigned_to', 'ticket_number', 'priority')
                        ->orderColumns('subject', 'from', 'assigned_to', 'Last Replier', 'ticket_number', 'priority', 'Last')
                        ->make();
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
}
