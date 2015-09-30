<?php namespace App\Http\Controllers\Agent\helpdesk;
// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Controllers\Common\SettingsController;
// requests
use App\Http\Requests\helpdesk\CreateTicketRequest;
use App\Http\Requests\helpdesk\TicketRequest;
use App\Http\Requests\helpdesk\TicketEditRequest;
// models
use App\Model\helpdesk\Email\Banlist;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Collaborator;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Settings\Alert;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Manage\Help_topic;
use App\User;
// classes
use Auth;
use Hash;
use Input;
use Mail;
use PDF;

/**
 * TicketController
 *
 * @package 	Controllers
 * @subpackage 	Controller
 * @author     	Ladybird <info@ladybirdweb.com>
 */
class TicketController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type response
	 */
	public function __construct() {
		SettingsController::smtp();
		$this->middleware('auth');
	}

	/**
	 * Show the Inbox ticket list page
	 * @return type response
	 */
	public function inbox_ticket_list() {
		return view('themes.default1.agent.helpdesk.ticket.inbox');
	}

	/**
	 * Show the Open ticket list page
	 * @return type response
	 */
	public function open_ticket_list() {
		return view('themes.default1.agent.helpdesk.ticket.open');
	}

	/**
	 * Show the answered ticket list page
	 * @return type response
	 */
	public function answered_ticket_list() {
		return view('themes.default1.agent.helpdesk.ticket.answered');
	}

	/**
	 * Show the Myticket list page
	 * @return type response
	 */
	public function myticket_ticket_list() {
		return view('themes.default1.agent.helpdesk.ticket.myticket');
	}

	/**
	 * Show the Overdue ticket list page
	 * @return type response
	 */
	public function overdue_ticket_list() {
		return view('themes.default1.agent.helpdesk.ticket.overdue');
	}

	/**
	 * Show the Closed ticket list page
	 * @return type response
	 */
	public function closed_ticket_list() {
		return view('themes.default1.agent.helpdesk.ticket.closed');
	}

	/**
	 * Show the ticket list page
	 * @return type response
	 */
	public function assigned_ticket_list() {
		return view('themes.default1.agent.helpdesk.ticket.assigned');
	}

	/**
	 * Show the New ticket page
	 * @return type response
	 */
	public function newticket() {
		return view('themes.default1.agent.helpdesk.ticket.new');
	}

	/**
	 * Save the data of new ticket and show the New ticket page with result
	 * @param type CreateTicketRequest $request
	 * @return type response
	 */
	public function post_newticket(CreateTicketRequest $request) {
		$email = $request->input('email');
		$fullname = $request->input('fullname');
		$helptopic = $request->input('helptopic');
		$sla = $request->input('sla');
		$duedate = $request->input('duedate');
		$assignto = $request->input('assignto');

		$subject = $request->input('subject');
		$body = $request->input('body');
		$priority = $request->input('priority');
		$phone = $request->input('phone');
		$source = "3";
		$headers = null;
		$help = Help_topic::where('id','=',$helptopic)->first();	
		//create user
		if ($this->create_user($email, $fullname, $subject, $body, $phone, $helptopic, $sla, $priority, $source, $headers, $help->department, $assignto)) {
			return Redirect('newticket')->with('success', 'Ticket created successfully!');
		} else {
			return Redirect('newticket')->with('fails', 'fails');
		}
	}

	/**
	 * Shows the ticket thread details
	 * @param type $id
	 * @return type response
	 */
	public function thread($id) {
		$lock = Tickets::where('id','=',$id)->first();
		if($lock->lock_by == Auth::user()->id || $lock->lock_at < date('Y-m-d H:i:s', strtotime('-3 minutes', strtotime($lock->lock_at)))) {
			if(Auth::user()->role == 'agent'){
				
				$dept = Department::where('name','=',Auth::user()->primary_dpt)->first();

				$tickets = Tickets::where('id', '=', $id)->where('dept_id','=', $dept->id)->first();
			} else {
				$tickets = Tickets::where('id', '=', $id)->first();
			}
			$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
			return view('themes.default1.agent.helpdesk.ticket.timeline', compact('tickets'), compact('thread'));
		} else {
			return Redirect()->back()->with('fails', 'This ticket has been locked by other agent');
		}			
	}

	/**
	 * Replying a ticket
	 * @param type Ticket_Thread $thread
	 * @param type TicketRequest $request
	 * @return type bool
	 */

	public function reply(Ticket_Thread $thread, TicketRequest $request, Ticket_attachments $ta ) {
	  	$attachments = $request->file('attachment');
	  	$check_attachment = null;
	  	// dd($attachments);
	  	// }
	  	//return $attachments;
	  	$reply_content = $request->input('ReplyContent');
	  	$thread->ticket_id = $request->input('ticket_ID');
	  	$thread->poster = 'support';
	  	$thread->body = $request->input('ReplyContent');
	  	$thread->user_id = Auth::user()->id;
	  	$ticket_id = $request->input('ticket_ID');
	  	//dd($ticket_id);
	  	$tickets = Tickets::where('id', '=', $ticket_id)->first();
		$tickets->isanswered = '1';
		$tickets->save();

	  	$ticket_user = User::where('id','=',$tickets->user_id)->first();

	  	if($tickets->assigned_to == 0 )
	  	{
		   	$tickets->assigned_to = Auth::user()->id;
		 	$tickets->save();
		   	$thread2 = New Ticket_Thread;
		    $thread2->ticket_id = $thread->ticket_id;
		   	$thread2->user_id = Auth::user()->id;
		   	$thread2->is_internal = 1;
		   	$thread2->body = "This Ticket have been assigned to " . Auth::user()->first_name . " " . Auth::user()->last_name;
		   	$thread2->save();
	  	}
	  	if($tickets->status > 1)
	  	{
	   		$tickets->status = '1';
	   		$tickets->isanswered = '1';
	  		$tickets->save(); 
	  	}
	  	$thread->save();
	  	
	  	//$atachPath = '';
	   	foreach ($attachments as $attachment) {
	    	if($attachment != null){
	    		$name = $attachment->getClientOriginalName();
	    		//dd(dirname($attachment));
	    		$type = $attachment->getClientOriginalExtension();
	    		$size = $attachment->getSize();
	    		$data = file_get_contents($attachment->getRealPath());
	    		// $tem_path = $attachment->getRealPath();
	    		// $tem = basename($tem_path).PHP_EOL;
	    		// //dd($tem);
	    		$attachPath=$attachment->getRealPath();
	    		//dd($attachPath);
	    		$ta->create(['thread_id' => $thread->id,'name'=>$name,'size'=>$size,'type'=>$type,'file'=>$data,'poster'=>'ATTACHMENT']);

	    		$check_attachment = 1;
		   } else {
		   		$check_attachment = null;
		   }
  		}

  		
		$thread = Ticket_Thread::where('ticket_id', '=', $ticket_id)->first();
	  	$ticket_subject = $thread->title;
	  	$user_id = $tickets->user_id;
	  	$user = User::where('id','=',$user_id)->first();
	  	$email = $user->email;
	  	$user_name = $user->user_name;
	  	$ticket_number = $tickets->ticket_number;
	  	$company = $this->company();
	  	$username  =  $ticket_user->user_name;
  		if(!empty(Auth::user()->agent_sign)) {
		    $agentsign = Auth::user()->agent_sign; 
  		}
  		else{
   			$agentsign = null;  
  		}
  
		  	// foreach($attachments as $attachment){ 
		  	// $pathToFile = $attachment->getRealPath();
		  	// $name = $attachment->name;
		  	// $data = $attachment->file;
		  	// $display = $attachment->file;
		  	// $mime = $attachment->type;
		  	// }
		  	//dd(sizeOf($attachments));
		  	//$size = sizeOf($attachments);
		  	//dd($thread->id);\
		   	// mail to main user
		  	//$path = 'C:\wamp\tmp\php5D3A.tmp';
		   	Mail::send(array('html'=>'emails.ticket_re-reply'), ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name'=>$username, 'Agent_Signature' => $agentsign], function ($message) use ($email, $user_name, $ticket_number, $ticket_subject, $attachments, $check_attachment) {
    		$message->to($email, $user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
    		// if(isset($attachments)){
    		if($check_attachment == 1){
	    		$size = sizeOf($attachments);
	    		for($i=0;$i<$size;$i++){
	           	$message->attach($attachments[$i]->getRealPath(), ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
	           	}
           	}
           	},true);

   
   			$collaborators = Ticket_Collaborator::where('ticket_id','=',$ticket_id)->get();
   			foreach ($collaborators as $collaborator) {
    			//mail to collaborators
    			$collab_user_id = $collaborator->user_id;
			    $user_id_collab = User::where('id','=',$collab_user_id)->first();
			    $collab_email = $user_id_collab->email;
			    if($user_id_collab->role == "user") {
			    	$collab_user_name = $user_id_collab->user_name;
				} else {
					$collab_user_name = $user_id_collab->first_name . " " . $user_id_collab->last_name;
				}
			    Mail::send('emails.ticket_re-reply', ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name'=>$collab_user_name, 'Agent_Signature' => $agentsign], function ($message) use ($collab_email, $collab_user_name, $ticket_number, $ticket_subject, $attachments, $check_attachment) {
			    $message->to($collab_email, $collab_user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
				if($check_attachment == 1){
	    			$size = sizeOf($attachments);
	    			for($i=0;$i<$size;$i++){
	           			$message->attach($attachments[$i]->getRealPath(), ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
	           			}
           			}
           		},true);
   			}
			return 1;
 		}

	/**
	 * Ticket edit and save ticket data
	 * @param type $ticket_id
	 * @param type Ticket_Thread $thread
	 * @return type bool
	 */
	public function ticket_edit_post($ticket_id, Ticket_Thread $thread, Tickets $ticket) {

		if (Input::get('subject') == null) {
			return 1;
		}
		elseif (Input::get('sla_paln') == null) {
			return 2;	
		}
		elseif (Input::get('help_topic') == null) {
			return 3;
		}
		elseif (Input::get('ticket_source') == null) {
			return 4;
		}
		elseif (Input::get('ticket_priority') == null) {
			return 5;
		}
		else {
			$ticket = $ticket->where('id', '=', $ticket_id)->first();		
			$ticket->sla_id = Input::get("sla_paln");
			$ticket->help_topic_id = Input::get("help_topic");
			$ticket->source = Input::get("ticket_source");
			$ticket->priority_id = Input::get("ticket_priority");
			$ticket->save();

			$threads = $thread->where('ticket_id', '=', $ticket_id)->first();		
			$threads->title = Input::get("subject");
			$threads->save();
			return 0;
		}
	}

	/**
	 * Print Ticket Details
	 * @param type $id
	 * @return type respponse
	 */
	public function ticket_print($id) {
		$tickets = Tickets::where('id', '=', $id)->first();
		$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
		$html = view('themes.default1.agent.helpdesk.ticket.pdf', compact('id', 'tickets', 'thread'))->render();
		return PDF::load($html)->show();
	}

	/**
	 * Generates Ticket Number
	 * @param type $ticket_number
	 * @return type integer
	 */
	public function ticket_number($ticket_number) {
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
		$array = array($number1, $number2, $number3);
		$number = implode('-', $array);
		return $number;
	}

	/**
	 * check email for dublicate entry
	 * @param type $email
	 * @return type bool
	 */
	public function check_email($email) {
		$check = User::where('email', '=', $email)->first();
		if ($check == true) {
			return $check;
		} else {
			return false;
		}
	}

	/**
	 * Create User while creating ticket
	 * @param type $emailadd
	 * @param type $username
	 * @param type $subject
	 * @param type $body
	 * @param type $phone
	 * @param type $helptopic
	 * @param type $sla
	 * @param type $priority
	 * @param type $system
	 * @return type bool
	 */
	public function create_user($emailadd, $username, $subject, $body, $phone, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto) {
		// define global variables
		// dd($source);
		$email;
		$username;
		// check emails
		$ticket_creator = $username;
		$checkemail = $this->check_email($emailadd);
		$company = $this->company();
		if ($checkemail == false) {
			// Generate password
			$password = $this->generateRandomString();
			// create user
			$user = new User;
			if($username == null)
			{
				$username = $emailadd;
			}
			$user->user_name = $username;
			$user->email = $emailadd;
			$user->password = Hash::make($password);
			$user->phone_number = $phone;
			$user->role = "user";
			$user->active = "1";
			// mail user his/her password
			if ($user->save()) {
				$user_id = $user->id;
				if (Mail::send('emails.pass', ['password' => $password, 'name' => $username, 'from'=>$company], function ($message) use ($emailadd, $username) {
					$message->to($emailadd, $username)->subject('password');
				})) {
					// need to do something here....
				}
			}
		} else {
			$username = $checkemail->username;
			$user_id = $checkemail->id;
		}
		$ticket_number = $this->check_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto);
		$ticket_number2 = $ticket_number[0];
		$ticketdata = Tickets::where('ticket_number','=',$ticket_number2)->first();
		$threaddata = Ticket_Thread::where('ticket_id','=',$ticketdata->id)->first();
		// dd($threaddata);
		$is_reply = $ticket_number[1];
		$system = $this->system();
		$updated_subject = $threaddata->title . '[#' . $ticket_number2 . ']';
		if($ticket_number2)
		{
		// send ticket create details to user
			if($is_reply == 0)
			{
				$mail = "Admin_mail";
				Mail::send('emails.Ticket_Create', ['name' => $username, 'ticket_number' => $ticket_number2, 'from'=>$company, 'system' => $system], function ($message) use ($emailadd, $username, $ticket_number2, $updated_subject) {
					$message->to($emailadd, $username)->subject($updated_subject);
				});
			}
			else
			{
				$mail = "email_reply";
			}

			if(Alert::first()->ticket_status == 1 || Alert::first()->ticket_admin_email == 1) {
				// send email to admin
				$admins = User::where('role','=','admin')->get();
				// $ticket_creator = $user->user_name;
				foreach($admins as $admin)
				{
					$admin_email = $admin->email;
					$admin_user = $admin->first_name;
					Mail::send('emails.'.$mail, ['agent' => $admin_user,'content'=>$body, 'ticket_number' => $ticket_number2, 'from'=>$company, 'email' => $emailadd, 'name' => $ticket_creator, 'system' => $system], function ($message) use ($admin_email, $admin_user, $ticket_number2, $updated_subject) {
						$message->to($admin_email, $admin_user)->subject($updated_subject);
					});
				}
			}

			if(Alert::first()->ticket_status == 1 || Alert::first()->ticket_department_member == 1) {
				// send email to agents
				$agents = User::where('role','=','agent')->get();
				foreach($agents as $agent)
				{
					if($ticketdata->dept_id == $agent->primary_dpt)
					{
						$agent_email = $agent->email;
						$agent_user = $agent->first_name;
						Mail::send('emails.'.$mail, ['agent' => $agent_user, 'ticket_number' => $ticket_number2, 'from'=>$company, 'email' => $emailadd, 'name' => $ticket_creator, 'system' => $system], function ($message) use ($agent_email, $agent_user, $ticket_number2, $updated_subject) {
							$message->to($agent_email, $agent_user)->subject($updated_subject);
						});
					}
				}
			}
			return true;
		}
	}

	/**
	 * Default helptopic
	 * @return type string
	 */
	public function default_helptopic() {
		$helptopic = "1";
		return $helptopic;
	}

	/**
	 * Default SLA plan
	 * @return type string
	 */
	public function default_sla() {
		$sla = "1";
		return $sla;
	}

	/**
	 * Default Priority
	 * @return type string
	 */
	public function default_priority() {
		$priority = "1";
		return $prioirty;
	}

	/**
	 * Check the response of the ticket
	 * @param type $user_id
	 * @param type $subject
	 * @param type $body
	 * @param type $helptopic
	 * @param type $sla
	 * @param type $priority
	 * @return type string
	 */
	public function check_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto) {
			// $read_ticket_number = substr($subject, 0, 6);
			$read_ticket_number = explode('[#',$subject);
			if(isset($read_ticket_number[1]))
			{
				// dd($read_ticket_number);
			// if ($read_ticket_number == 'Re: [#' or $read_ticket_number == 'RE: [#') {
			// dd($read_ticket_number);
			$separate = explode("]", $read_ticket_number[1]);
			$new_subject = substr($separate[0], 0, 20);
			$find_number = Tickets::where('ticket_number', '=', $new_subject)->first();
			$thread_body = explode("---Reply above this line---", $body);
			$body = $thread_body[0];
			if (count($find_number) > 0) {
				$id = $find_number->id;
				$ticket_number = $find_number->ticket_number;
				if($find_number->status > 1)
				{	
					$find_number->status = 1;
					$find_number->save();

					$ticket_status = Ticket_Status::where('id','=',1)->first();

					$user_name = User::where('id','=', $user_id)->first();

					if($user_name->role == 'user' )
					{
						$username = $user_name->user_name;
					}
					elseif($user_name->role == 'agent' or $user_name->role == 'admin')
					{
						$username = $user_name->first_name . " " . $user_name->last_name;	
					}

					$ticket_threads = new Ticket_Thread;
		    		$ticket_threads->ticket_id = $id;
					$ticket_threads->user_id = $user_id;
					$ticket_threads->is_internal = 1;
					$ticket_threads->body = $ticket_status->message. " " . $username;
					$ticket_threads->save();					

				}
				if (isset($id)) {
					if ($this->ticket_thread($subject, $body, $id, $user_id)) {
						return array($ticket_number,1);
					}
				}
			} else {
				$ticket_number = $this->create_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto);
				return array($ticket_number,0);
			}
		} else {
			$ticket_number = $this->create_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto);
			return array($ticket_number,0);
		}
	}

	/**
	 * Create Ticket
	 * @param type $user_id
	 * @param type $subject
	 * @param type $body
	 * @param type $helptopic
	 * @param type $sla
	 * @param type $priority
	 * @return type string
	 */
	public function create_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto) {
		$max_number = Tickets::whereRaw('id = (select max(`id`) from tickets)')->first();
			if($max_number == null)
			{
				$ticket_number = "AAAA-9999-9999999";		
			}
			else
			{
				foreach ($max_number as $number) {
					$ticket_number = $max_number->ticket_number;
				}
			}
		$ticket = new Tickets;
		$ticket->ticket_number = $this->ticket_number($ticket_number);
		$ticket->user_id = $user_id;
		$ticket->dept_id = $dept;
		$ticket->help_topic_id = $helptopic;
		$ticket->sla = $sla;
		$ticket->assigned_to = $assignto;
		$ticket->status = '1';
		$ticket->priority_id = $priority;
		$ticket->source = $source;
		$ticket->save();
		$ticket_number = $ticket->ticket_number;
		$id = $ticket->id;
		// store collaborators
		$this->store_collaborators($headers, $id);

		if ($this->ticket_thread($subject, $body, $id, $user_id) == true) {
			return $ticket_number;
		}
	}

	/**
	 * Generate Ticket Thread
	 * @param type $subject
	 * @param type $body
	 * @param type $id
	 * @param type $user_id
	 * @return type
	 */
	public function ticket_thread($subject, $body, $id, $user_id) {
		$thread = new Ticket_Thread;
		$thread->user_id = $user_id;
		$thread->ticket_id = $id;
		$thread->poster = 'client';
		$thread->title = $subject;
		$thread->body = $body;
		if ($thread->save()) {
			return true;
		}
	}

	/**
	 * Generate a random string for password
	 * @param type $length
	 * @return type string
	 */
	public function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	/**
	 * function to Ticket Close
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type string
	 */
	public function close($id, Tickets $ticket) {
		$ticket_status = $ticket->where('id', '=', $id)->first();
		$ticket_status->status = 3;
		$ticket_status->closed_at = date('Y-m-d H:i:s');
		$ticket_status->save();
		$ticket_thread = Ticket_Thread::where('ticket_id','=',$ticket_status->id)->first();
		$ticket_subject = $ticket_thread->title;
		$ticket_status_message = Ticket_Status::where('id','=',$ticket_status->status)->first();
		$thread = New Ticket_Thread;
		$thread->ticket_id = $ticket_status->id;
		$thread->user_id = Auth::user()->id;
		$thread->is_internal = 1;
		$thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
		$thread->save();
		
		$user_id = $ticket_status->user_id;
		$user = User::where('id','=',$user_id)->first();
		$email = $user->email;
		$user_name = $user->user_name;
		$ticket_number = $ticket_status->ticket_number;

		$company = $this->company();

		Mail::send('emails.close_ticket', ['ticket_number' => $ticket_number, 'from'=>$company], function ($message) use ($email, $user_name, $ticket_number, $ticket_subject) {
			$message->to($email, $user_name)->subject($ticket_subject.'[#' . $ticket_number . ']');
		});

		return "your ticket" . $ticket_status->ticket_number . " has been closed";
	}

	/**
	 * function to Ticket resolved
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type string
	 */
	public function resolve($id, Tickets $ticket) {
		$ticket_status = $ticket->where('id', '=', $id)->first();
		$ticket_status->status = 2;
		$ticket_status->save();
		$ticket_status_message = Ticket_Status::where('id','=',$ticket_status->status)->first();
		$thread = New Ticket_Thread;
		$thread->ticket_id = $ticket_status->id;
		$thread->user_id = Auth::user()->id;
		$thread->is_internal = 1;
		$thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
		$thread->save();
		return "your ticket" . $ticket_status->ticket_number . " has been resolved";
	}

	/**
	 * function to Open Ticket
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type
	 */
	public function open($id, Tickets $ticket) {
		$ticket_status = $ticket->where('id', '=', $id)->first();
		$ticket_status->status = 1;
		$ticket_status->reopened_at = date('Y-m-d H:i:s');
		$ticket_status->save();
		$ticket_status_message = Ticket_Status::where('id','=',$ticket_status->status)->first();
		$thread = New Ticket_Thread;
		$thread->ticket_id = $ticket_status->id;
		$thread->user_id = Auth::user()->id;
		$thread->is_internal = 1;
		$thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
		$thread->save();
		return "your ticket" . $ticket_status->ticket_number . " has been opened";
	}

	/**
	 * Function to delete ticket
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type string
	 */
	public function delete($id, Tickets $ticket) {
		$ticket_delete = $ticket->where('id', '=', $id)->first();
		if($ticket_delete->status == 5)
		{
			$ticket_delete->delete();
			$ticket_threads = Ticket_Thread::where('ticket_id','=',$id)->get();
			foreach($ticket_threads as $ticket_thread)
			{
				$ticket_thread->delete();
			}
			$ticket_attachments = Ticket_attachments::where('ticket_id','=',$id)->get();
			foreach ($ticket_attachments as $ticket_attachment) 
			{
				$ticket_attachment->delete();
			}
			return "your ticket has been delete";	
		}
		else
		{
			$ticket_delete->is_deleted = 0;
			$ticket_delete->status = 5;
			$ticket_delete->save();
			$ticket_status_message = Ticket_Status::where('id','=',$ticket_delete->status)->first();
			$thread = New Ticket_Thread;
			$thread->ticket_id = $ticket_delete->id;
			$thread->user_id = Auth::user()->id;
			$thread->is_internal = 1;
			$thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
			$thread->save();
			return "your ticket" . $ticket_delete->ticket_number . " has been delete";	
		}
		
	}

	/**
	 * Function to ban an email
	 * @param type $id
	 * @param type Tickets $ticket
	 * @return type string
	 */
	public function ban($id, Tickets $ticket) {
		$ticket_ban = $ticket->where('id', '=', $id)->first();
		$ban_email = $ticket_ban->user_id;
		$user = User::where('id', '=', $ban_email)->first();
		$user->ban = 1;
		$user->save();
		$Email = $user->email;
		return "the user has been banned";
	}

	/**
	 * function to assign ticket
	 * @param type $id
	 * @return type bool
	 */
	public function assign($id) {
		$UserEmail = Input::get('user');
		// $UserEmail = 'sujitprasad12@yahoo.in';
		$user = User::where('email', '=', $UserEmail)->first();
		$user_id = $user->id;
		$ticket = Tickets::where('id', '=', $id)->first();
		$ticket_number = $ticket->ticket_number;
		$ticket->assigned_to = $user_id;
		$ticket->save();
		$ticket_thread = Ticket_Thread::where('ticket_id','=',$id)->first();
		$ticket_subject = $ticket_thread->title;
		$thread = New Ticket_Thread;
		$thread->ticket_id = $ticket->id;
		$thread->user_id = Auth::user()->id;
		$thread->is_internal = 1;
		$thread->body = "This Ticket has been assigned to " . $user->first_name . " " . $user->last_name;
		$thread->save();

		$company = $this->company();
		$system = $this->system();

			$agent = $user->first_name;
			$agent_email = $user->email;

			$master = Auth::user()->first_name . " " . Auth::user()->last_name;
			if(Alert::first()->internal_status == 1 || Alert::first()->internal_assigned_agent == 1) {
				// ticket assigned send mail
				Mail::send('emails.Ticket_assign', ['agent' => $agent, 'ticket_number' => $ticket_number, 'from'=>$company, 'master' => $master, 'system' => $system], function ($message) use ($agent_email, $agent, $ticket_number) {
						$message->to($agent_email, $agent)->subject($ticket_subject.'[#' . $ticket_number . ']');
					});
			}

		return 1;
	}

	/**
	 * Function to post internal note
	 * @param type $id
	 * @return type bool
	 */
	public function InternalNote($id) {
		$InternalContent = Input::get('InternalContent');
		$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
		$NewThread = new Ticket_Thread;
		$NewThread->ticket_id = $thread->ticket_id;
		$NewThread->user_id = Auth::user()->id;
		// $NewThread->thread_type = 'M';
		$NewThread->is_internal = 1;
		$NewThread->poster = Auth::user()->role;
		$NewThread->title = $thread->title;
		$NewThread->body = $InternalContent;
		$NewThread->save();
		return 1;
	}

	/**
	 * Function to surrender a ticket
	 * @param type $id
	 * @return type bool
	 */
	public function surrender($id) {
		$ticket = Tickets::where('id', '=', $id)->first();

		// if($ticket->assigned_to == Auth::user()->id)
		// {
			$InternalContent = Auth::user()->first_name." ".Auth::user()->last_name . " has Surrendered the assigned Ticket";
			$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
			$NewThread = new Ticket_Thread;
			$NewThread->ticket_id = $thread->ticket_id;
			$NewThread->user_id = Auth::user()->id;
			$NewThread->is_internal = 1;
			$NewThread->poster = Auth::user()->role;
			$NewThread->title = $thread->title;
			$NewThread->body = $InternalContent;
			$NewThread->save();
		// }

		$ticket->assigned_to = 0;
		$ticket->save();

		return 1;
	}

	/**
	 * Search
	 * @param type $keyword 
	 * @return type array
	 */
	public function search($keyword) {    
    	if(isset($keyword)) {
      		$data = array('ticket_number' => Tickets::search($keyword));     
	      	return $data;
   		} else {
    	return "no results";
    	}
 	}

 	/**
	 * Search
	 * @param type $keyword 
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
	 * store_collaborators
	 * @param type $headers 
	 * @return type
	 */
	public function store_collaborators($headers, $id)
	{
		$company = $this->company();
		if(isset($headers)) {
			foreach ($headers as $email=>$name) {
				$name = $name;
				$email = $email;
				if($this->check_email($email) == false) {
					$create_user = new User;
					$create_user->user_name = $name;
					$create_user->email = $email;
					$create_user->active = 1;
					$create_user->role = "user";
					$password = $this->generateRandomString();
					$create_user->password = Hash::make($password);
					$create_user->save();
					$user_id = $create_user->id;
					Mail::send('emails.pass', ['password' => $password, 'name' => $name, 'from'=>$company], function ($message) use ($email, $name) {
						$message->to($email, $name)->subject('password');
					});
				}
				else{
					$user = $this->check_email($email);
					$user_id = $user->id;
				}
				$collaborator_store = new Ticket_Collaborator;
				$collaborator_store->isactive = 1;
				$collaborator_store->ticket_id = $id;
				$collaborator_store->user_id = $user_id;
				$collaborator_store->role = "ccc";
				$collaborator_store->save();
			}
		}
		return true;
	}

	/**
	 * company
	 * @return type
	 */
	public function company()
	{
		$company = Company::Where('id','=','1')->first();
		if($company->company_name == null){
			$company = "Support Center";  
		}else{
			$company = $company->company_name;
		}
		return $company;
	}

	/**
	 * system
	 * @return type
	 */
	public function system()
	{
		$system = System::Where('id','=','1')->first();
		if($system->name == null){
			$system = "Support Center";  
		}else{
			$system = $system->name;
		}
		return $system;
	}

	/**
	 * function to search
	 * @return type
	 */
	// public function search() {
	// 	$product = Input::get('type');
	// 	$word = Input::get('name_startsWith');

	// 	if ($product == 'product') {
	// 		$starts_with = strtoupper($word);
	// 		$rows = DB::table('users')->select('user_name')->where('name', 'LIKE', $starts_with . '%')->get();
	// 		$data = array();
	// 		foreach ($rows as $row) {
	// 			array_push($data, $row->name);
	// 		}
	// 		print_r(json_encode($data));
	// 	}

	// 	if ($product == 'product_table') {
	// 		$row_num = Input::get('row_num');
	// 		$starts_with = strtoupper($word);
	// 		$rows = DB::table('product')->select('name', 'description', 'cost_price')->where('name', 'LIKE', $starts_with . '%')->get();
	// 		$data = array();
	// 		foreach ($rows as $row) {
	// 			$name = $row->name . '|' . $row->description . '|' . $row->cost_price . '|' . $row_num;
	// 			array_push($data, $name);
	// 		}
	// 		print_r(json_encode($data));
	// 	}
	// }

	/**
	 * shows trashed tickets
	 * @return type response
	 */
	public function trash() {
		return view('themes.default1.agent.helpdesk.ticket.trash');
	}

	/**
	 * shows unassigned tickets
	 * @return type
	 */
	public function unassigned() {
		return view('themes.default1.agent.helpdesk.ticket.unassigned');
	}

	/**
	 * shows tickets assigned to Auth::user()
	 * @return type
	 */
	public function myticket() {
		return view('themes.default1.agent.helpdesk.ticket.myticket');
	}


	/**
	 * cleanMe
	 * @param type $input 
	 * @return type
	 */
	public function cleanMe($input) {
		$input = mysqli_real_escape_string($input);
		$input = htmlspecialchars($input, ENT_IGNORE, 'utf-8');
		$input = strip_tags($input);
		$input = stripslashes($input);
		return $input;
	}

	/** 
	 * autosearch
	 * @param type Image $image 
	 * @return type json
	 */
   	public function autosearch($id)
   	{
   		$term = \Input::get('term');
   		$user = \App\User::where('email', 'LIKE', '%'.$term.'%')->lists('email');
   		echo json_encode($user);
   	}

   	/** 
	 * autosearch2
	 * @param type Image $image 
	 * @return type json
	 */
   	public function autosearch2(User $user)
   	{
   	$user = $user->lists('email');
   	echo json_encode($user);
   	}

	/** 
	 * autosearch
	 * @param type Image $image 
	 * @return type json
	 */
   	public function usersearch()
   	{
   		$email = Input::get('search');	
   		$ticket_id = Input::get('ticket_id');	
   		$data = User::where('email','=',$email)->first();

		$ticket_collaborator = Ticket_Collaborator::where('ticket_id','=',$ticket_id)->where('user_id','=',$data->id)->first();   		
		if(!isset($ticket_collaborator))
   		{
	   		$ticket_collaborator = new Ticket_Collaborator;
	   		$ticket_collaborator->isactive = 1;
	   		$ticket_collaborator->ticket_id = $ticket_id;
	   		$ticket_collaborator->user_id = $data->id;
	   		$ticket_collaborator->role = 'ccc';
	   		$ticket_collaborator->save();
	   		return  '<div id="alert11" class="alert alert-dismissable" style="color:#60B23C;background-color:#F2F2F2;"><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Success!</h4><h4><i class="icon fa fa-user"></i>'.$data->user_name.'</h4><div id="message-success1">'.$data->email.'</div></div>';
	   	} else {
	   		return  '<div id="alert11" class="alert alert-warning alert-dismissable"><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i>'.$data->user_name.'</h4><div id="message-success1">'.$data->email.'<br/>This user already Collaborated</div></div>';
	   	}
   	}

   	/** 
	 * useradd
	 * @param type Image $image 
	 * @return type json
	 */
   	public function useradd()
   	{
   		$name = Input::get('name');
   		$email = Input::get('email');
   		$ticket_id = Input::get('ticket_id');	
   		$user_search = User::where('email','=',$email)->first();
   		if(isset($user_serach)){
			return  '<div id="alert11" class="alert alert-warning alert-dismissable" ><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-alert"></i>Alert!</h4><div id="message-success1">This user already Exists</div></div>';
   		} else {
   			$company = $this->company();
   			$user = new User;
   			$user->user_name = $name;
			$user->email = $email;
			$password = $this->generateRandomString();
			$user->password = $password;
			$user->role = 'user';
   			if ($user->save()) {
				$user_id = $user->id;
				Mail::send('emails.pass', ['password' => $password, 'name' => $name, 'from'=>$company], function ($message) use ($email, $name) {
					$message->to($email, $name)->subject('password');
				});
			}
			$ticket_collaborator = new Ticket_Collaborator;
   			$ticket_collaborator->isactive = 1;
   			$ticket_collaborator->ticket_id = $ticket_id;
   			$ticket_collaborator->user_id = $user->id;
   			$ticket_collaborator->role = 'ccc';
   			$ticket_collaborator->save();
   			return  '<div id="alert11" class="alert alert-dismissable" style="color:#60B23C;background-color:#F2F2F2;"><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-user"></i>'.$user->user_name.'</h4><div id="message-success1">'.$user->email.'</div></div>';
   		}
   		// return  '<div id="alert11" class="alert alert-dismissable" ><button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-user"></i>'.$data->user_name.'</h4><div id="message-success1">'.$data->email.'</div></div>';
   	}

   	/**
   	 * user remove
   	 * @return type
   	 */
   	public function userremove()
   	{
   		$id = Input::get('data1');
   		$ticket_collaborator = Ticket_Collaborator::where('id','=',$id)->delete();
   		return 1;
   	}

   	/**
   	 * select_all
   	 * @return type
   	 */
   	public function select_all() {

   		if(Input::has('select_all'))
   		{
	   		$selectall = Input::get('select_all');
	   		// dd($selectall);
	   		$value = Input::get('submit');
	   		// dd($value);
	   		foreach($selectall as $delete)
				   	{
				   		var_dump($delete);
				   		$ticket = Tickets::whereId($delete)->first();
				   		if($value == "Delete"){
				   			$ticket->status = 5;
				   			$ticket->save();
				   		} elseif($value == "Close") {
				   			$ticket->status = 2;
				   			$ticket->save();
				   		} elseif($value == "Open") {
				   			$ticket->status = 1;
				   			$ticket->save();
				   		}
				   	}
				   	if($value == "Delete"){
						return redirect()->back()->with('success',' Moved to trash');
					} elseif($value == "Close") {
						return redirect()->back()->with('success',' Tickets has been Closed');
					} elseif($value == "Open") {
						return redirect()->back()->with('success',' Ticket has been Opened');
					}
		}
		return redirect()->back()->with('fails','None Selected!');
   	}

   	/**
   	 * user time zone
   	 * @param type $utc 
   	 * @return type date
   	 */
	public static function usertimezone($utc) {
		$set = System::whereId('1')->first();
		$tz = $set->time_zone;
		$format = $set->date_time_format;
		date_default_timezone_set($tz);
		$offset = date('Z', strtotime($utc));
		$date = date($format, strtotime($utc) + $offset);
		return $date;
 	}

 	/**
 	 * lock
 	 * @param type $id 
 	 * @return type null
 	 */
 	public function lock($id){
 		$ticket = Tickets::where('id','=',$id)->first();
 		$ticket->lock_by = Auth::user()->id;
 		$ticket->lock_at = date('Y-m-d H:i:s');
 		$ticket->save();
	}

	/**
	 * Show the deptopen ticket list page
	 * @return type response
	 */
	public function deptopen($id) {
		$dept = Department::where('name','=',$id)->first();	
		if(Auth::user()->role == 'agent') {	
			if(Auth::user()->primary_dpt == $dept->name) {
				return view('themes.default1.agent.helpdesk.dept-ticket.open',compact('id'));		
			} else {
				return redirect()->back()->with('fails','Unauthorised!');
			}
		} else {
			return view('themes.default1.agent.helpdesk.dept-ticket.open',compact('id'));	
		}
	}

	/**
	 * Show the deptclose ticket list page
	 * @return type response
	 */
	public function deptclose($id) {
		$dept = Department::where('name','=',$id)->first();	
		if(Auth::user()->role == 'agent') {	
			if(Auth::user()->primary_dpt == $dept->name) {
				return view('themes.default1.agent.helpdesk.dept-ticket.closed',compact('id'));
			} else {
				return redirect()->back()->with('fails','Unauthorised!');
			}
		} else {
		return view('themes.default1.agent.helpdesk.dept-ticket.closed',compact('id'));
		}
	}

	/**
	 * Show the deptinprogress ticket list page
	 * @return type response
	 */
	public function deptinprogress($id) {
		$dept = Department::where('name','=',$id)->first();	
		if(Auth::user()->role == 'agent') {	
			if(Auth::user()->primary_dpt == $dept->name) {
				return view('themes.default1.agent.helpdesk.dept-ticket.inprogress',compact('id'));
			} else {
				return redirect()->back()->with('fails','Unauthorised!');
			}
		} else {
		return view('themes.default1.agent.helpdesk.dept-ticket.inprogress',compact('id'));
		}
	}

}
