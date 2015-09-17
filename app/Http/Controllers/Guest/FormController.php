<?php
namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
/* include help topic model */
use App\Model\Form\Form_details;
/* Include form_name model */
use App\Model\Form\Form_name;
/* include form_detals model */
/* Include form_value model */
use App\Model\Manage\Help_topic;
use App\User;
use Form;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Model\Settings\Company;
/* Validate form TicketForm using */
use App\Model\Ticket\Tickets;
use App\Model\Ticket\Ticket_Thread;
use App\Model\Settings\System;
use App\Model\Settings\Ticket;
use App\Model\Agent\Department;
use App\Model\Ticket\Ticket_source;
use App\Http\Controllers\Agent\TicketController;
use Input;
use Mail;
use App\Http\Controllers\SettingsController;
use Hash;
use Redirect;
use Config;

/**
 * FormController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class FormController extends Controller {

	public function __construct(TicketController $TicketController) {
		SettingsController::smtp();
		$this->TicketController = $TicketController;
	}


	/**
	 * This Function to get the form for the ticket
	 * @param type Form_name $name
	 * @param type Form_details $details
	 * @param type Help_topic $topics
	 * @return type Response
	 */
	public function getForm() {
		if(Config::get('database.install') == '%0%')
		{
			return Redirect::route('license');
		}
		if(System::first()->status == 1)
		{
			return view('themes.default1.client.guest-user.form');
		}
		else
		{
			return "hello";	
		}
	}

	/**
	 * This Function to post the form for the ticket
	 * @param type Form_name $name
	 * @param type Form_details $details
	 * @return type string
	 */
	public function postForm($data,Form_name $name, Form_details $details) {
		$field = $details->where('form_name_id', $data)->get();
		$var = " ";
		foreach ($field as $key) {
			$type = $key->type;
			$label = $key->label;
			$var .= "," . $type . "-" . $label;
		}
		return $var;
	}

	/**
	 * Posted form
	 * @param type Request $request
	 * @param type User $user
	 */
	public function postedForm(User $user, ClientRequest $request, Ticket $ticket_settings, Ticket_source $ticket_source) {
		$name = $request->input('Name');
		$phone = $request->input('Phone');
		$email = $request->input('Email');
		$subject = $request->input('Subject');
		$details = $request->input('Details');

		$System = System::where('id','=',1)->first();
		$departments = Department::where('id','=',$System->department)->first();
		$department = $departments->id;

		$status = $ticket_settings->first()->status;
		$helptopic = $ticket_settings->first()->help_topic;
		$sla = $ticket_settings->first()->sla;
		$priority = $ticket_settings->first()->priority;
		$source = $ticket_source->where('name','=','web')->first();

		$collaborator = null;

		if($this->TicketController->create_user($email, $name, $subject, $details, $phone, $helptopic, $sla, $priority, $source, $collaborator, $department))
		{
			return Redirect::route('guest.getform')->with('success','Ticket Created Successfully');	
		}
	}	

}		