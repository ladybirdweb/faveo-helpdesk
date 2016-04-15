<?php

namespace App\Http\Controllers\Agent\helpdesk;

// 	controllers
use App\Http\Controllers\Common\PhpMailController;
//	Model
use App\Http\Controllers\Controller;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Teams;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\settings\Email;
use App\Model\helpdesk\Utility\Log_notification;
use App\User;
use View;

// classes

/**
 * NotificationController
 * This controller is used to send daily notifications.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class NotificationController extends Controller
{
    public function __construct(PhpMailController $PhpMailController)
    {
        $this->PhpMailController = $PhpMailController;
    }

    /**
     * 	This function is for sending daily report/notification about the system.
     * */
    public function send_notification()
    {
        //fetching email settings
        $email = Email::where('id', '=', '1')->first();
        // checking if the daily notification is enabled or not
        if ($email->notification_cron == 1) {
            // checking if current date is equal to the last entered daily notification log
            $notification = Log_notification::where('log', '=', 'NOT-1')->orderBy('id', 'DESC')->first();
            $date = explode(' ', $notification->created_at);
            if (date('Y-m-d') == $date[0]) {
            } else {
                // creating a daily notification log
                Log_notification::create(['log' => 'NOT-1']);
                $company = $this->company();
                // Send notification details to admin
                $this->send_notification_to_admin($company);
                // Send notification details to team lead
                $this->send_notification_to_team_lead($company);
                // Send notification details to manager of a department
                $this->send_notification_to_manager($company);
                // Send notification details to all the agents
                $this->send_notification_to_agent($company);
            }
        }
    }

    /**
     * 	Admin Notification/Report.
     *
     * 	@param company
     *
     * 	@return mail
     * */
    public function send_notification_to_admin($company)
    {
        // get all admin users
        $users = User::where('role', '=', 'admin')->get();
        foreach ($users as $user) {
            // Send notification details to admin
            $email = $user->email;
            $user_name = $user->first_name.' '.$user->last_name;
            $view = View::make('emails.notifications.admin', ['company' => $company, 'name' => $user_name]);
            $contents = $view->render();
            $this->PhpMailController->sendEmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $user_name, 'email' => $email], $message = ['subject' => 'Dily Report', 'scenario' => null, 'body' => $contents]);

//            \Mail::send('emails.notifications.admin', ['company' => $company, 'name' => $user_name], function ($message) use ($email, $user_name, $company) {
//                $message->to($email, $user_name)->subject($company.' Daily Report ');
//            });
        }
    }

    /**
     * 	Department Manager Notification/Report.
     *
     * 	@return mail
     * */
    public function send_notification_to_manager($company)
    {
        // get all department managers
        $depts = Department::all();
        foreach ($depts as $dept) {
            if (isset($dept->manager)) {
                $dept_name = $dept->name;
                $users = User::where('id', '=', $dept->manager)->get();
                foreach ($users as $user) {
                    // Send notification details to manager of a department
                    $email = $user->email;
                    $user_name = $user->first_name.' '.$user->last_name;
                    $view = View::make('emails.notifications.manager', ['company' => $company, 'name' => $user_name]);
                    $contents = $view->render();
                    $this->PhpMailController->sendEmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $user_name, 'email' => $email], $message = ['subject' => 'Dily Report', 'scenario' => null, 'body' => $contents]);

//                    \Mail::send('emails.notifications.manager', ['company' => $company, 'name' => $user_name, 'dept_id' => $dept->id, 'dept_name' => $dept->name], function ($message) use ($email, $user_name, $company, $dept_name) {
//                        $message->to($email, $user_name)->subject($company.' Daily Report for department manager of '.$dept_name.' department.');
//                    });
                }
            }
        }
    }

    /**
     *  Team Lead Notification/Report.
     *
     * 	@return mail
     * */
    public function send_notification_to_team_lead($company)
    {
        // get all Team leads
        $teams = Teams::all();
        foreach ($teams as $team) {
            if (isset($team->team_lead)) {
                $team_name = $team->name;
                $users = User::where('id', '=', $team->team_lead)->get();
                foreach ($users as $user) {
                    // Send notification details to team lead
                    $email = $user->email;
                    $user_name = $user->first_name.' '.$user->last_name;
                    $view = View::make('emails.notifications.lead', ['company' => $company, 'name' => $user_name]);
                    $contents = $view->render();
                    $this->PhpMailController->sendEmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $user_name, 'email' => $email], $message = ['subject' => 'Dily Report', 'scenario' => null, 'body' => $contents]);

//                    \Mail::send('emails.notifications.lead', ['company' => $company, 'name' => $user_name, 'team_id' => $team->id], function ($message) use ($email, $user_name, $company, $team_name) {
//                        $message->to($email, $user_name)->subject($company.' Daily Report for Team Lead of team '.$team_name);
//                    });
                }
            }
        }
    }

    /**
     * 	Agent Notification/Report.
     *
     * 	@return mail
     * */
    public function send_notification_to_agent($company)
    {
        // get all agents users
        $users = User::where('role', '=', 'agent')->get();
        foreach ($users as $user) {
            // Send notification details to all the agents
            $email = $user->email;
            $user_name = $user->first_name.' '.$user->last_name;
            $view = View::make('emails.notifications.agent', ['company' => $company, 'name' => $user_name]);
            $contents = $view->render();
            $this->PhpMailController->sendEmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $user_name, 'email' => $email], $message = ['subject' => 'Dily Report', 'scenario' => null, 'body' => $contents]);

//            \Mail::send('emails.notifications.agent', ['company' => $company, 'name' => $user_name, 'user_id' => 1], function ($message) use ($email, $user_name, $company) {
//                $message->to($email, $user_name)->subject($company.' Daily Report for Agents');
//            });
        }
    }

    /**
     * Fetching company name.
     *
     * @return type variable
     */
    public function company()
    {
        // fetching comapny model
        $company = Company::Where('id', '=', '1')->first();
        // fetching company name
        if ($company->company_name == null) {
            $company = 'Support Center';
        } else {
            $company = $company->company_name;
        }

        return $company;
    }

    // // testing
    // public function test(){
    // 	$email = "sujit.prasad@ladybirdweb.com";
    // 	$user_name = "sujit prasad";
    // 	\Mail::send('emails.notifications.test', ['user_id' => 1], function ($message) use($email, $user_name) {
    //     	$message->to($email, $user_name)->subject('testing reporting');
    // 	});
    // }
}
