<?php namespace App\Http\Controllers\Client\helpdesk;
// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Controllers\Common\SettingsController;
// requests
use Illuminate\Http\Request;
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
use App\User;
// classes
use Auth;
use Hash;
use Input;
use Mail;
use PDF;

/**
 * TicketController2
 *
 * @package 	Controllers
 * @subpackage 	Controller
 * @author     	Ladybird <info@ladybirdweb.com>
 */
class ClientTicketController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type response
	 */
	public function __construct() {
		SettingsController::smtp();
		// $this->middleware('auth');
		// $this->middleware('role.user');
	}

	/**
	 * Get Checked ticket
	 * @param type Tickets $ticket
	 * @param type User $user
	 * @return type response
	 */
	public function getCheckTicket(Tickets $ticket, User $user) {
		return view('themes.default1.client.helpdesk.guest-user.newticket', compact('ticket'));
	}

	/**
	 * reply
	 * @param type $value 
	 * @return type view
	 */
	public function reply($id, Request $request) {
		$comment = $request->input('comment');
		if($comment != null) {
			$tickets = Tickets::where('id','=',$id)->first();
			$threads = new Ticket_Thread;
			$threads->user_id = Auth::user()->id;
			$threads->ticket_id = $tickets->id;
			$threads->poster = "client";
			$threads->body = $comment;
			$threads->save();
			return \Redirect::back()->with('success1','Successfully replied');	
		} else {
			return \Redirect::back()->with('fails1','Please fill some data!');	
		}
		

	}

}

