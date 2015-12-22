<?php namespace App\Http\Controllers\Agent\helpdesk;

// 	controllers
use App\Http\Controllers\Controller;
//	Model
use App\User;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Agent\Teams;
use App\Model\helpdesk\Agent\Department;

/**
 * UserController
 *
 * @package   	Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class NotificationController extends Controller {

	/**
	 *	This function is for sending daily report/notification about the system
	 * 	@return mail
	 **/ 
	public function send_notification() {
		// $this->test();
		$company = $this->company();
		// $this->send_notification_to_admin($company);
		// $this->send_notification_to_team_lead($company);
		// $this->send_notification_to_manager($company);
		// $this->send_notification_to_agent($company);
	}

	/**
	 *	Admin Notification/Report
	 * 	@param company
	 * 	@return mail
	 **/ 
	public function send_notification_to_admin($company) {
		// get all admin users
		$users =	User::where('role','=','admin')->get();
		foreach ($users as $user) {
			$email = $user->email;
			$user_name = $user->first_name . " " . $user->last_name;
			\Mail::send('emails.notifications.admin', ['company' => $company, 'name'=>$user_name], function ($message)use ($email, $user_name, $company) {
    			$message->to($email, $user_name)->subject($company . ' Daily Report ');
			});
		}
	}

	/**
	 *	Department Manager Notification/Report
	 * 	@return mail
	 **/ 
	public function send_notification_to_manager($company) {
		$depts = Department::all();
		foreach ($depts as $dept) {
			if(isset($dept->manager)) {
				$dept_name = $dept->name;
				$users = User::where('id','=',$dept->manager)->get();	
				foreach ($users as $user) {
					$email = $user->email;
					$user_name = $user->first_name . " " . $user->last_name;
					\Mail::send('emails.notifications.manager', ['company' => $company, 'name'=>$user_name,'dept_id' => $dept->id, 'dept_name' => $dept->name], function ($message)use ($email, $user_name, $company, $dept_name) {
    					$message->to($email, $user_name)->subject($company . ' Daily Report for department manager of '. $dept_name.' department.');
					});
				}
			}
		}
	}

	/**
	 *  Team Lead Notification/Report
	 * 	@return mail
	 **/ 
	public function send_notification_to_team_lead($company) {
		$teams = Teams::all();
		foreach ($teams as $team) {
			if(isset($team->team_lead)) {
				$team_name = $team->name;
				$users = User::where('id','=',$team->team_lead)->get();	
				foreach ($users as $user) {
					$email = $user->email;
					$user_name = $user->first_name . " " . $user->last_name;
					\Mail::send('emails.notifications.lead', ['company' => $company, 'name'=>$user_name,'team_id' => $team->id], function ($message)use ($email, $user_name, $company, $team_name) {
    					$message->to($email, $user_name)->subject($company . ' Daily Report for Team Lead of team '. $team_name);
					});
				}
			}
		}
	}

	/**
	 *	Agent Notification/Report
	 * 	@return mail
	 **/ 
	public function send_notification_to_agent($company) {
		// get all agents users
		$users =	User::where('role','=','agent')->get();
		foreach ($users as $user) {
			$email = $user->email;
			$user_name = $user->first_name . " " . $user->last_name;
			\Mail::send('emails.notifications.agent', ['company' => $company, 'name'=>$user_name, 'user_id' => 1], function ($message)use ($email, $user_name, $company) {
    			$message->to($email, $user_name)->subject($company . ' Daily Report for Agents');
			});
		}
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

	public function test(){
		$email = "sujit.prasad@ladybirdweb.com";
		$user_name = "sujit prasad";
		\Mail::send('emails.notifications.test', ['user_id' => 1], function ($message) use($email, $user_name) {
	    	$message->to($email, $user_name)->subject('testing reporting');
		});
	}

}