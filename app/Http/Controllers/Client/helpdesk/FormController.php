<?php namespace App\Http\Controllers\Client\helpdesk;
// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Controllers\Common\SettingsController;
// requests
use Illuminate\Http\Request;
use App\Http\Requests\helpdesk\ClientRequest;
// models
/* include help topic model */
use App\Model\helpdesk\Form\Form_details;
/* Include form_name model */
use App\Model\helpdesk\Form\Form_name;
/* include form_detals model */
/* Include form_value model */
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Settings\Company;
/* Validate form TicketForm using */
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\User;
// classes
use Form;
use Input;
use Mail;
use Hash;
use Redirect;
use Config;

use DateTime;
use DateTimeZone;
use App\Model\helpdesk\Form\Fields;
use App\Model\helpdesk\Form\Form_value;


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

	// /**
	//  * This Function to get the form for the ticket
	//  * @param type Form_name $name
	//  * @param type Form_details $details
	//  * @param type Help_topic $topics
	//  * @return type Response
	//  */
	// public function getForm() {
	// 	if(Config::get('database.install') == '%0%') {
	// 		return Redirect::route('license');
	// 	}
	// 	if(System::first()->status == 1) {
	// 		return view('themes.default1.client.helpdesk.guest-user.form');
	// 	} else {
	// 		return "hello";	
	// 	}
	// }

	/**
	 * getform
	 * @param type Help_topic $topic 
	 * @return type
	 */
 	public function getForm(Help_topic $topic) {
 		if(\Config::get('database.install') == '%0%') {
			return \Redirect::route('license');
		}
		if(System::first()->status == 1) {
			$topics = $topic->get();
			return view('themes.default1.client.helpdesk.form', compact('topics'));
		} else {
			return \Redirect::route('home');
		}
	}

	/**
	 * This Function to post the form for the ticket
	 * @param type Form_name $name
	 * @param type Form_details $details
	 * @return type string
	 */
	public function postForm($id,Form_name $name, Form_details $details, Help_topic $topic) {
		// dd($id);
		if($id != 0 ){
			$helptopic = $topic->where('id', '=', $id)->first();
			$custom_form = $helptopic->custom_form;
			$values = Fields::where('forms_id', '=', $custom_form)->get();
			if(!$values) {
			} if($values) {
		        foreach($values as $value){
		         	if($value->type == "select") {
		            	$data = $value->value;
		             	$value = explode(',', $data);            
		             	echo '<select class="form-control">';             
		             	foreach($value as $option){             
		            		echo '<option>'.$option.'</option>';           
		            	}
		            	echo '</select></br>';
		           	} elseif ($value->type == "radio" ) {
		             	$type2 = $value->value;
		             	$val = explode(',', $type2);             
		             	echo '<label class="radio-inline">'.$value->label.'</label>&nbsp&nbsp&nbsp<input type="'.$value->type.'" name="'.$value->name.'">&nbsp;&nbsp;'.$val[0].'
		            	&nbsp&nbsp&nbsp<input type="'.$value->type.'" name="'.$value->name.'">&nbsp;&nbsp;'.$val[1].'</br>';
		         	} elseif($value->type == "textarea" ) {         
		             	$type3 = $value->value;
		             	$v = explode(',', $type3); 
		             	//dd($v);
		             	if(array_key_exists(1, $v)){            
		             		echo '<label>'.$value->label.'</label></br><textarea class=form-control rows="'.$v[0].'" cols="'.$v[1].'"></textarea></br>';
		         		} else {
		         			echo '<label>'.$value->label.'</label></br><textarea class=form-control rows="10" cols="60"></textarea></br>';         	
		         		}
		         	} elseif($value->type == "checkbox" ) { 
		             	$type4 = $value->value;
		             	$check = explode(',', $type4);
		             	echo '<label class="radio-inline">'.$value->label.'&nbsp&nbsp&nbsp<input type="'.$value->type.'" name="'.$value->name.'">&nbsp&nbsp'.$check[0].'</label><label class="radio-inline"><input type="'.$value->type.'" name="'.$value->name.'">&nbsp&nbsp'.$check[1].'</label></br>';          
		            } else {
		         		echo '<label>'.$value->label.'</label><input type="'.$value->type.'" class="form-control"   name="'.$value->name.'" /></br>';
		        	}
		   		}
			}
		} else {
			return null;
		}
	}

	/**
	 * Posted form
	 * @param type Request $request
	 * @param type User $user
	 */
	public function postedForm(User $user, ClientRequest $request, Ticket $ticket_settings, Ticket_source $ticket_source) {
		
		$form_extras = $request->except('Name','Phone','Email','Subject','Details','helptopic','_wysihtml5_mode','_token');

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

		if($this->TicketController->create_user($email, $name, $subject, $details, $phone, $helptopic, $sla, $priority, $source->id, $collaborator, $department,$assignto = "", $form_extras)) {
			return Redirect::route('guest.getform')->with('success','Ticket Created Successfully');	
		}
	}	



	/**
	 * reply
	 * @param type $value 
	 * @return type view
	 */
	public function post_ticket_reply($id, Request $request) {
		$comment = $request->input('comment');
		if($comment != null) {
			$tickets = Tickets::where('id','=',$id)->first();
			$threads = new Ticket_Thread;
			$threads->user_id = $tickets->user_id;
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