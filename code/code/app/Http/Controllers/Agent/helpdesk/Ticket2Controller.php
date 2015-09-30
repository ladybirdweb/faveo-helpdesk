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
class Ticket2Controller extends Controller {

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
	public function deptopen($id) {
		$dept = Department::where('name','=',$id)->first();	
		if(Auth::user()->role == 'agent') {	
			if(Auth::user()->dept_id == $dept->id) {
				return view('themes.default1.agent.helpdesk.dept-ticket.open',compact('id'));		
			} else {
				return redirect()->back()->with('fails','Unauthorised!');
			}
		} else {
			return view('themes.default1.agent.helpdesk.dept-ticket.open',compact('id'));	
		}
	}

	/**
	 * Show the Inbox ticket list page
	 * @return type response
	 */
	public function deptclose($id) {
		$dept = Department::where('name','=',$id)->first();	
		if(Auth::user()->role == 'agent') {	
			if(Auth::user()->dept_id == $dept->id) {
				return view('themes.default1.agent.helpdesk.dept-ticket.closed',compact('id'));
			} else {
				return redirect()->back()->with('fails','Unauthorised!');
			}
		} else {
		return view('themes.default1.agent.helpdesk.dept-ticket.closed',compact('id'));
		}
	}

	/**
	 * Show the Inbox ticket list page
	 * @return type response
	 */
	public function deptinprogress($id) {
		$dept = Department::where('name','=',$id)->first();	
		if(Auth::user()->role == 'agent') {	
			if(Auth::user()->dept_id == $dept->id) {
				return view('themes.default1.agent.helpdesk.dept-ticket.inprogress',compact('id'));
			} else {
				return redirect()->back()->with('fails','Unauthorised!');
			}
		} else {
		return view('themes.default1.agent.helpdesk.dept-ticket.inprogress',compact('id'));
		}
	}

}
