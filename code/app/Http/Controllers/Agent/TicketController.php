<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\TicketRequest;
use App\Model\Email\Banlist;
use App\Model\Ticket\Tickets;
use App\Model\Ticket\Ticket_Thread;
use App\User;
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
		$this->middleware('auth');
	}

	/**
	 * Show the ticket list page
	 * @return type response
	 */
	public function ticket_list() {
		return view('themes.default1.agent.ticket.ticket');
	}

	/**
	 * Show the Open ticket list page
	 * @return type response
	 */
	public function open_ticket_list() {
		return view('themes.default1.agent.ticket.open');
	}

	/**
	 * Show the answered ticket list page
	 * @return type response
	 */
	public function answered_ticket_list() {
		return view('themes.default1.agent.ticket.answered');
	}

	/**
	 * Show the Myticket list page
	 * @return type response
	 */
	public function myticket_ticket_list() {
		return view('themes.default1.agent.ticket.myticket');
	}

	/**
	 * Show the Overdue ticket list page
	 * @return type response
	 */
	public function overdue_ticket_list() {
		return view('themes.default1.agent.ticket.overdue');
	}

	/**
	 * Show the Closed ticket list page
	 * @return type response
	 */
	public function closed_ticket_list() {
		return view('themes.default1.agent.ticket.closed');
	}

	/**
	 * Show the New ticket page
	 * @return type response
	 */
	public function newticket() {
		return view('themes.default1.agent.ticket.new');
	}

	/**
	 * Save the data of new ticket and show the New ticket page with result
	 * @param type CreateTicketRequest $request
	 * @return type response
	 */
	public function post_newticket(CreateTicketRequest $request) {
		$email = $request->input('email');
		$fullname = $request->input('fullname');
		$notice = $request->input('notice');
		$helptopic = $request->input('helptopic');
		$dept = $request->input('dept');
		$sla = $request->input('sla');
		$duedate = $request->input('duedate');
		$assignto = $request->input('assignto');
		$subject = $request->input('subject');
		$body = $request->input('body');
		$priority = $request->input('priority');
		$phone = "";
		$system = "";
		//create user
		if ($this->create_user($email, $fullname, $subject, $body, $phone, $helptopic, $sla, $priority, $system)) {
			return Redirect('newticket')->with('success', 'success');
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
		$tickets = Tickets::where('id', '=', $id)->first();
		$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
		return view('themes.default1.agent.ticket.timeline', compact('tickets'), compact('thread'));
	}

	/**
	 * Replying a ticket
	 * @param type Ticket_Thread $thread
	 * @param type TicketRequest $request
	 * @return type bool
	 */
	public function reply(Ticket_Thread $thread, TicketRequest $request) {
		$thread->ticket_id = $request->input('ticket_ID');
		$thread->poster = 'support';
		$thread->body = $request->input('ReplyContent');
		$thread->save();
		$ticket_id = $request->input('ticket_ID');
		$tickets = Tickets::where('id', '=', $ticket_id)->first();
		$thread = Ticket_Thread::where('ticket_id', '=', $ticket_id)->first();
		return 1;
	}

	/**
	 * Ticket edit and save ticket data
	 * @param type $ticket_id
	 * @param type Ticket_Thread $thread
	 * @return type bool
	 */
	public function ticket_edit_post($ticket_id, Ticket_Thread $thread) {
		$threads = $thread->where('ticket_id', '=', $ticket_id)->first();
		if (Input::get('subject') != null && Input::get('body') != null) {
			$threads->title = Input::get('subject');
			$threads->body = Input::get('body');
			if ($threads->save()) {
				return 1;
			} else {
				return 0;
			}
		}
		return 0;
	}

	/**
	 * Print Ticket Details
	 * @param type $id
	 * @return type respponse
	 */
	public function ticket_print($id) {
		$tickets = Tickets::where('id', '=', $id)->first();
		$thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
		$html = view('themes.default1.agent.ticket.pdf', compact('id', 'tickets', 'thread'))->render();
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
	public function create_user($emailadd, $username, $subject, $body, $phone, $helptopic, $sla, $priority, $system) {
		// define global variables
		$email;
		$username;
		// check emails
		$checkemail = $this->check_email($emailadd);

		if ($checkemail == false) {
			// Generate password
			$password = $this->generateRandomString();
			// create user
			$user = new User;
			$user->user_name = $username;
			$user->email = $emailadd;
			$user->password = Hash::make($password);
			// mail user his/her password
			if ($user->save()) {
				$user_id = $user->id;
				if (Mail::send('emails.pass', ['password' => $password, 'name' => $username], function ($message) use ($emailadd, $username) {
					$message->to($emailadd, $username)->subject('password');
				})) {
					// need to do something here....
				}
			}
		} else {
			$username = $checkemail->username;
			$user_id = $checkemail->id;
		}
		$ticket_number = $this->check_ticket($user_id, $subject, $body, $helptopic, $sla, $priority);
		// send ticket create details to user
		if (Mail::send('emails.Ticket_Create', ['name' => $username, 'ticket_number' => $ticket_number], function ($message) use ($emailadd, $username, $ticket_number) {
			$message->to($emailadd, $username)->subject('[~' . $ticket_number . ']');
		})) {
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
	public function check_ticket($user_id, $subject, $body, $helptopic, $sla, $priority) {
		$read_ticket_number = substr($subject, 0, 6);
		if ($read_ticket_number == 'Re: [~') {
			$separate = explode("]", $subject);
			$new_subject = substr($separate[0], 6, 20);
			$find_number = Tickets::where('ticket_number', '=', $new_subject)->first();
			$thread_body = explode("---Reply above this line---", $body);
			$body = $thread_body[0];
			if (count($find_number) > 0) {
				$id = $find_number->id;
				$ticket_number = $find_number->ticket_number;
				if (isset($id)) {
					if ($this->ticket_thread($subject, $body, $id, $user_id)) {
						return $ticket_number;
					}
				}
			} else {
				$ticket_number = $this->create_ticket($user_id, $subject, $body, $helptopic, $sla, $priority);
				return $ticket_number;
			}
		} else {
			$ticket_number = $this->create_ticket($user_id, $subject, $body, $helptopic, $sla, $priority);
			return $ticket_number;
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
	public function create_ticket($user_id, $subject, $body, $helptopic, $sla, $priority) {
		$max_number = Tickets::whereRaw('id = (select max(`id`) from tickets)')->get();
		foreach ($max_number as $number) {
			$ticket_number = $number->ticket_number;
		}
		$ticket = new Tickets;
		$ticket->ticket_number = $this->ticket_number($ticket_number);
		$ticket->user_id = $user_id;
		$ticket->help_topic_id = $helptopic;
		$ticket->sla = $sla;
		$ticket->status = '1';
		$ticket->priority_id = $priority;
		$ticket->save();
		$ticket_number = $ticket->ticket_number;
		$id = $ticket->id;
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
		$ticket_status->save();
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
		$ticket_status->save();
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
		$ticket_delete->is_deleted = 0;
		$ticket_delete->status = 5;
		$ticket_delete->save();
		return "your ticket" . $ticket_delete->ticket_number . " has been delete";
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
		$user->is_ban = 1;
		$user->save();
		$Email = $user->email;
		$ban = Banlist::where('email_address', '=', $Email)->first();
		if ($ban == null) {
			$banlist = new Banlist;
			$banlist->ban_status = 1;
			$banlist->email_address = $user->email;
			$banlist->save();
		}
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
		$ticket->assigned_to = $user_id;
		$ticket->save();
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
		$NewThread->thread_type = 'M';
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
		$ticket->assigned_to = 0;
		$ticket->save();
		return 1;
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
		return view('themes.default1.agent.ticket.trash');
	}

	/**
	 * shows unassigned tickets
	 * @return type
	 */
	public function unassigned() {
		return view('themes.default1.agent.ticket.unassigned');
	}

	/**
	 * shows tickets assigned to Auth::user()
	 * @return type
	 */
	public function myticket() {
		return view('themes.default1.agent.ticket.myticket');
	}

}
