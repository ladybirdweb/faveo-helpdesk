<?php

namespace App\Api\v1;

use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Controller;
use App\Model\helpdesk\Settings\Alert;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Collaborator;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;
use Auth;
use Hash;
use Illuminate\Support\Facades\Request;
use Mail;

/**
 * -----------------------------------------------------------------------------
 * Ticket Controller
 * -----------------------------------------------------------------------------.
 *
 *
 * @author Vijay Sebastian <vijay.sebastian@ladybirdweb.com>
 * @copyright (c) 2016, Ladybird Web Solution
 *
 * @name Faveo HELPDESK
 *
 * @version v1
 */
class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type response
     */
    public function __construct()
    {
        $PhpMailController = new PhpMailController();
        $this->PhpMailController = $PhpMailController;
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
    public function createTicket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data, $attach = '')
    {
        try {
            //return $headers;
            $max_number = Tickets::whereRaw('id = (select max(`id`) from tickets)')->first();
            //dd($max_number);
            if ($max_number == null) {
                $ticket_number = 'AAAA-9999-9999999';
            } else {
                foreach ($max_number as $number) {
                    $ticket_number = $max_number->ticket_number;
                }
            }
            $ticket = new Tickets();
            $ticket->ticket_number = $this->ticketNumber($ticket_number);
            //dd($this->ticketNumber($ticket_number));
            $ticket->user_id = $user_id;
            $ticket->dept_id = $dept;
            $ticket->help_topic_id = $helptopic;
            $ticket->sla = $sla;
            $ticket->assigned_to = $assignto;
            $ticket->status = '1';
            $ticket->priority_id = $priority;
            $ticket->source = $source;
            $ticket->save();
            //dd($ticket);
            $ticket_number = $ticket->ticket_number;
            $id = $ticket->id;
            if ($form_data != null) {
                $help_topic = Help_topic::where('id', '=', $helptopic)->first();
                $forms = Fields::where('forms_id', '=', $help_topic->custom_form)->get();
                foreach ($form_data as $key => $form_details) {
                    foreach ($forms as $from) {
                        if ($from->name == $key) {
                            $form_value = new Ticket_Form_Data();
                            $form_value->ticket_id = $id;
                            $form_value->title = $from->label;
                            $form_value->content = $form_details;
                            $form_value->save();
                        }
                    }
                }
            }
            //return $headers;
            $this->storeCollaborators($headers, $id);

            $thread = $this->ticketThread($subject, $body, $id, $user_id);
            if (!empty($attach)) {
                $this->attach($thread, $attach);
            }

            return $thread;
        } catch (\Exception $e) {
            return $e->getMessage();
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
        try {
            //return $headers;
            $company = $this->company();
            if (isset($headers)) {
                foreach ($headers as $email) {
                    $name = $email;
                    $email = $email;
                    if ($this->checkEmail($email) == false) {
                        $create_user = new User();
                        $create_user->user_name = $name;
                        $create_user->email = $email;
                        $create_user->active = 1;
                        $create_user->role = 'user';
                        $password = $this->generateRandomString();
                        $create_user->password = Hash::make($password);
                        $create_user->save();
                        $user_id = $create_user->id;
                        // Mail::send('emails.pass', ['password' => $password, 'name' => $name, 'from' => $company, 'emailadd' => $email], function ($message) use ($email, $name) {
                        //     $message->to($email, $name)->subject('password');
                        // });

                        $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $email], $message = ['subject' => 'password', 'scenario' => 'registration-notification'], $template_variables = ['user' => $name, 'email_address' => $email, 'user_password' => $password]);
                    } else {
                        $user = $this->checkEmail($email);
                        $user_id = $user->id;
                    }
                    //return $user_id;
                    $collaborator_store = new Ticket_Collaborator();
                    $collaborator_store->isactive = 1;
                    $collaborator_store->ticket_id = $id;
                    $collaborator_store->user_id = $user_id;
                    $collaborator_store->role = 'ccc';
                    $collaborator_store->save();
                }
            }

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
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
        try {
            $thread = new Ticket_Thread();
            $thread->user_id = $user_id;
            $thread->ticket_id = $id;
            $thread->poster = 'client';
            $thread->title = $subject;
            $thread->body = $body;
            $thread->save();

            return $thread->id;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Generates Ticket Number.
     *
     * @param type $ticket_number
     *
     * @return type integer
     */
    public function ticketNumber($ticket_number)
    {
        try {
            //dd($ticket_number);
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
        } catch (\Exception $e) {
            dd($e);

            return $e->getMessage();
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
        try {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            return $randomString;
        } catch (\Exception $e) {
            return $e->getMessage();
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
    public function reply($thread, $request, $ta, $attach = '')
    {
        try {
            $check_attachment = null;
            $eventthread = $thread->where('ticket_id', $request->input('ticket_id'))->first();
            //dd($request->input('ticket_ID'));
            //dd($eventthread);
            $eventuserid = $eventthread->user_id;
            $emailadd = User::where('id', $eventuserid)->first()->email;
            //dd($emailadd);
            $source = $eventthread->source;

            $form_data = $request->except('reply_content', 'ticket_ID', 'attachment');
            event(new \App\Events\ClientTicketFormPost($form_data, $emailadd, $source));
            $reply_content = $request->input('reply_content');
            $thread->ticket_id = $request->input('ticket_id');
            $thread->poster = 'support';
            $thread->body = $request->input('reply_content');
            $thread->user_id = Auth::user()->id;
            $ticket_id = $request->input('ticket_id');
            $tickets = Tickets::where('id', '=', $ticket_id)->first();
            $tickets->isanswered = '1';
            $tickets->save();

            $ticket_user = User::where('id', '=', $tickets->user_id)->first();

            if ($tickets->assigned_to == 0) {
                $tickets->assigned_to = Auth::user()->id;
                $tickets->save();
                $thread2 = new Ticket_Thread();
                $thread2->ticket_id = $thread->ticket_id;
                $thread2->user_id = Auth::user()->id;
                $thread2->is_internal = 1;
                $thread2->body = 'This Ticket have been assigned to '.Auth::user()->first_name.' '.Auth::user()->last_name;
                $thread2->save();
            }
            if ($tickets->status > 1) {
                $tickets->status = '1';
                $tickets->isanswered = '1';
                $tickets->save();
            }
            $thread->save();

            if (!empty($attach)) {
                $check_attachment = $this->attach($thread->id, $attach);
            }

            $thread1 = Ticket_Thread::where('ticket_id', '=', $ticket_id)->first();
            $ticket_subject = $thread1->title;
            $user_id = $tickets->user_id;
            $user = User::where('id', '=', $user_id)->first();
            $email = $user->email;
            $user_name = $user->user_name;
            $ticket_number = $tickets->ticket_number;
            $company = $this->company();
            $username = $ticket_user->user_name;
            if (!empty(Auth::user()->agent_sign)) {
                $agentsign = Auth::user()->agent_sign;
            } else {
                $agentsign = null;
            }
            event(new \App\Events\FaveoAfterReply($reply_content, $user->phone_number, $request, $tickets));

//             Mail::send(array('html' => 'emails.ticket_re-reply'), ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name' => $username, 'Agent_Signature' => $agentsign], function ($message) use ($email, $user_name, $ticket_number, $ticket_subject, $check_attachment) {
//                 $message->to($email, $user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
//                 // if(isset($attachments)){
            // //                if ($check_attachment == 1) {
            // //                    $size = count($attach);
            // //                    for ($i = 0; $i < $size; $i++) {
            // //                        $message->attach($attachments[$i]->getRealPath(), ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
            // //                    }
            // //                }
//             }, true);
            //dd('reply');
            /*
             * Getting the subject of the thread
             */
            //dd($eventthread);
            try {
                $re = $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $tickets->dept_id), $to = ['name' => $user_name, 'email' => $email], $message = ['subject' => $eventthread->title, 'scenario' => 'create-ticket-by-agent', 'body' => $thread->body], $template_variables = ['agent_sign' => Auth::user()->agent_sign, 'ticket_number' => $tickets->number]);
                //dd($re);
            } catch (\Exception $e) {
                //throw new \Exception($e->getMessage());
            }

            $collaborators = Ticket_Collaborator::where('ticket_id', '=', $ticket_id)->get();
            foreach ($collaborators as $collaborator) {
                //mail to collaborators
                $collab_user_id = $collaborator->user_id;
                $user_id_collab = User::where('id', '=', $collab_user_id)->first();
                $collab_email = $user_id_collab->email;
                if ($user_id_collab->role == 'user') {
                    $collab_user_name = $user_id_collab->user_name;
                } else {
                    $collab_user_name = $user_id_collab->first_name.' '.$user_id_collab->last_name;
                }
//                 Mail::send('emails.ticket_re-reply', ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name' => $collab_user_name, 'Agent_Signature' => $agentsign], function ($message) use ($collab_email, $collab_user_name, $ticket_number, $ticket_subject, $check_attachment) {
//                     $message->to($collab_email, $collab_user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
                // //                    if ($check_attachment == 1) {
                // //                        $size = sizeOf($attachments);
                // //                        for ($i = 0; $i < $size; $i++) {
                // //                            $message->attach($attachments[$i]->getRealPath(), ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
                // //                        }
                // //                    }
//                 }, true);

                try {
                    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticketdata->dept_id), $to = ['user' => $admin_user, 'email' => $admin_email], $message = ['subject' => $updated_subject, 'body' => $body, 'scenario' => $mail], $template_variables = ['ticket_agent_name' => $admin_user, 'ticket_client_name' => $username, 'ticket_client_email' => $emailadd, 'user' => $admin_user, 'ticket_number' => $ticket_number2, 'email_address' => $emailadd, 'name' => $ticket_creator]);
                } catch (\Exception $e) {
                }
            }

            return $thread;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * company.
     *
     * @return type
     */
    public function company()
    {
        try {
            $company = Company::Where('id', '=', '1')->first();
            if ($company->company_name == null) {
                $company = 'Support Center';
            } else {
                $company = $company->company_name;
            }

            return $company;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Ticket edit and save ticket data.
     *
     * @param type $ticket_id
     * @param type Ticket_Thread $thread
     *
     * @return type bool
     */
    public function ticketEditPost($ticket_id, $thread, $ticket)
    {
        try {
            $ticket = $ticket->where('id', '=', $ticket_id)->first();

            $ticket->sla = Request::get('sla_plan');
            $ticket->help_topic_id = Request::get('help_topic');
            $ticket->source = Request::get('ticket_source');
            $ticket->priority_id = Request::get('ticket_priority');
            $ticket->status = Request::get('status');
            $ticket->save();

            $threads = $thread->where('ticket_id', '=', $ticket_id)->first();
            $threads->title = Request::get('subject');
            $threads->save();
        } catch (\Exception $ex) {
            $result = $ex->getMessage();

            return response()->json(compact('result'), 500);
        }
        $result = ['success' => 'Edited successfully'];

        return response()->json(compact('result'));
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
        try {
            $UserEmail = Request::get('user');
            //dd($UserEmail);
            // $UserEmail = 'sujitprasad12@yahoo.in';
            $user = User::where('email', '=', $UserEmail)->first();
            if (!$user) {
                return ['error' => 'No agent not found'];
            }
            $user_id = $user->id;
            $ticket = Tickets::where('id', '=', $id)->first();
            if (!$ticket) {
                return ['error' => 'No ticket not found'];
            }
            $ticket_number = $ticket->ticket_number;
            $ticket->assigned_to = $user_id;
            $ticket->save();
            $ticket_thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
            if (!$ticket_thread) {
                return ['error' => 'No thread not found'];
            }
            $ticket_subject = $ticket_thread->title;
            $thread = new Ticket_Thread();
            $thread->ticket_id = $ticket->id;
            $thread->user_id = Auth::user()->id;
            $thread->is_internal = 1;
            $thread->body = 'This Ticket has been assigned to '.$user->first_name.' '.$user->last_name;
            $thread->save();

            $company = $this->company();
            $system = $this->system();

            $agent = $user->first_name;
            $agent_email = $user->email;

            $master = Auth::user()->first_name.' '.Auth::user()->last_name;
            if (Alert::first()->internal_status == 1 || Alert::first()->internal_assigned_agent == 1) {
                // // ticket assigned send mail
                // Mail::send('emails.Ticket_assign', ['agent' => $agent, 'ticket_number' => $ticket_number, 'from' => $company, 'master' => $master, 'system' => $system], function ($message) use ($agent_email, $agent, $ticket_number, $ticket_subject) {
                //     $message->to($agent_email, $agent)->subject($ticket_subject . '[#' . $ticket_number . ']');
                // });

                try {
                    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $ticket->dept_id), $to = ['name' => $agent, 'email' => $agent_email], $message = ['subject' => $ticket_subject.'[#'.$ticket_number.']', 'scenario' => 'assign-ticket'], $template_variables = ['ticket_agent_name' => $agent, 'ticket_number' => $ticket_number, 'ticket_assigner' => $master]);
                } catch (\Exception $e) {
                    return 0;
                }
            }

            return 1;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to delete ticket.
     *
     * @param type $id
     * @param type Tickets $ticket
     *
     * @return type string
     */
    public function delete($ids, $ticket)
    {
        try {
            foreach ($ids as $id) {
                $ticket_delete = $ticket->where('id', '=', $id)->first();
                if ($ticket_delete) {
                    if ($ticket_delete->status == 5) {
                        $ticket_delete->delete();
                        $ticket_threads = Ticket_Thread::where('ticket_id', '=', $id)->get();
                        if ($ticket_threads) {
                            foreach ($ticket_threads as $ticket_thread) {
                                if ($ticket_thread) {
                                    $ticket_thread->delete();
                                }
                            }
                        }
                        $ticket_attachments = Ticket_attachments::where('thread_id', '=', $id)->get();
                        if ($ticket_attachments) {
                            foreach ($ticket_attachments as $ticket_attachment) {
                                if ($ticket_attachment) {
                                    $ticket_attachment->delete();
                                }
                            }
                        }
                    } else {
                        $ticket_delete->is_deleted = 0;
                        $ticket_delete->status = 5;
                        $ticket_delete->save();
                        $ticket_status_message = Ticket_Status::where('id', '=', $ticket_delete->status)->first();
                        $thread = new Ticket_Thread();
                        $thread->ticket_id = $ticket_delete->id;
                        $thread->user_id = Auth::user()->id;
                        $thread->is_internal = 1;
                        $thread->body = $ticket_status_message->message.' '.Auth::user()->first_name.' '.Auth::user()->last_name;
                        $thread->save();
                    }
                } else {
                    return 'ticket not found';
                }
            }

            return 'your tickets has been deleted';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
        try {
            $check = User::where('email', '=', $email)->first();
            if ($check) {
                return $check;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * system.
     *
     * @return type
     */
    public function system()
    {
        try {
            $system = System::Where('id', '=', '1')->first();
            if ($system->name == null) {
                $system = 'Support Center';
            } else {
                $system = $system->name;
            }

            return $system;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Create Attachment.
     *
     * @param type $thread
     * @param type $attach
     *
     * @return int
     */
    public function attach($thread, $attach)
    {
        try {
            $ta = new Ticket_attachments();
            foreach ($attach as $file) {
                $ta->create(['thread_id' => $thread, 'name' => $file['name'], 'size' => $file['size'], 'type' => $file['type'], 'file' => $file['file'], 'poster' => 'ATTACHMENT']);
            }
            $ta->create(['thread_id' => $thread, 'name' => $name, 'size' => $size, 'type' => $type, 'file' => $file, 'poster' => 'ATTACHMENT']);

            return 1;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * autosearch.
     *
     * @return type json
     */
    public function autosearch()
    {
        $term = Request::get('term');
        $user = \App\User::where('email', 'LIKE', '%'.$term.'%')->orWhere('first_name', 'LIKE', '%'.$term.'%')->orWhere('last_name', 'LIKE', '%'.$term.'%')->orWhere('user_name', 'LIKE', '%'.$term.'%')->pluck('email');

        return $user;
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
        $email = Request::get('email');
        $ticket_id = Request::get('ticket_id');
        $company = $this->company();
        $user = new User();
        $user->user_name = $email;
        $user->email = $email;
        $password = $this->generateRandomString();
        $user->password = \Hash::make($password);
        $user->role = 'user';
        $user->active = 1;
        if ($user->save()) {
            $user_id = $user->id;
            $php_mailer = new PhpMailController();
            $php_mailer->sendmail($from = $php_mailer->mailfrom('1', '0'), $to = ['name' => $email, 'email' => $email], $message = ['subject' => 'Password', 'scenario' => 'registration-notification'], $template_variables = ['user' => $email, 'email_address' => $email, 'user_password' => $password]);
        }
        $ticket_collaborator = new Ticket_Collaborator();
        $ticket_collaborator->isactive = 1;
        $ticket_collaborator->ticket_id = $ticket_id;
        $ticket_collaborator->user_id = $user->id;
        $ticket_collaborator->role = 'ccc';
        $ticket_collaborator->save();

        $result = [$user->user_name => $user->email];

        return $result;
    }

    /**
     * user remove.
     *
     * @return type
     */
    public function userremove()
    {
        $email = Request::get('email');
        $ticketid = Request::get('ticketid');
        $user = new User();
        $user = $user->where('email', $email)->first();
        $ticket_collaborator = Ticket_Collaborator::where('ticket_id', '=', $ticketid)
                ->where('user_id', $user->id)
                ->first();
        if ($ticket_collaborator) {
            $ticket_collaborator->delete();

            return 'deleted successfully';
        } else {
            return 'not found';
        }
    }

    public function getCollaboratorForTicket()
    {
        try {
            $ticketid = Request::get('ticket_id');

            $ticket_collaborator = \DB::table('users')
                    ->join('ticket_collaborator', function ($join) use ($ticketid) {
                        $join->on('users.id', '=', 'ticket_collaborator.user_id')
                        ->where('ticket_collaborator.ticket_id', '=', $ticketid);
                    })
                    ->select('users.email', 'users.user_name')
                    ->get();
            if (count($ticket_collaborator) > 0) {
                foreach ($ticket_collaborator as $key => $collaborator) {
                    $collab[$key]['email'] = $collaborator->email;
                    $collab[$key]['user_name'] = $collaborator->user_name;
                    $collab[$key]['avatar'] = $this->avatarUrl($collaborator->email);
                }
            } else {
                $collab = $ticket_collaborator;
            }

            return $collab;
        } catch (\Exception $ex) {
            return $ex->getMessage();

            throw new \Exception('get collaborator for ticket fails');
        }
    }

    public function avatarUrl($email)
    {
        try {
            $user = new User();
            $user = $user->where('email', $email)->first();
            if ($user->profile_pic) {
                $url = url('uploads/profilepic/'.$user->profile_pic);
            } else {
                $url = \Gravatar::src($email);
            }

            return $url;
        } catch (\Exception $ex) {
            //return $ex->getMessage();
            throw new \Exception($ex->getMessage());
        }
    }
}
