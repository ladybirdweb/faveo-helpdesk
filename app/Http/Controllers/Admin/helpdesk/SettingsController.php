<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\CompanyRequest;
use App\Http\Requests\helpdesk\EmailRequest;
use App\Http\Requests\helpdesk\Job\TaskRequest;
use App\Http\Requests\helpdesk\RatingUpdateRequest;
use App\Http\Requests\helpdesk\StatusRequest;
// models
use App\Http\Requests\helpdesk\SystemRequest;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Email\Template;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Notification\UserNotification;
use App\Model\helpdesk\Ratings\Rating;
use App\Model\helpdesk\Settings\Alert;
use App\Model\helpdesk\Settings\CommonSettings;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\Email;
use App\Model\helpdesk\Settings\Responder;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Utility\Date_format;
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\Model\helpdesk\Workflow\WorkflowClose;
// classes
use DateTime;
use DB;
use Exception;
use File;
use Illuminate\Http\Request;
use Input;
use Lang;

/**
 * SettingsController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->smtp();
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function getcompany(Company $company)
    {
        try {
            /* fetch the values of company from company table */
            $companys = $company->whereId('1')->first();
            /* Direct to Company Settings Page */
            return view('themes.default1.admin.helpdesk.settings.company', compact('companys'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int            $id
     * @param type Company        $company
     * @param type CompanyRequest $request
     *
     * @return Response
     */
    public function postcompany($id, Company $company, CompanyRequest $request)
    {
        /* fetch the values of company request  */
        $companys = $company->whereId('1')->first();
        if (Input::file('logo')) {
            $name = Input::file('logo')->getClientOriginalName();
            $destinationPath = 'uploads/company/';
            $fileName = rand(0000, 9999).'.'.$name;
            Input::file('logo')->move($destinationPath, $fileName);
            $companys->logo = $fileName;
        }
        if ($request->input('use_logo') == null) {
            $companys->use_logo = '0';
        }
        /* Check whether function success or not */
        try {
            $companys->fill($request->except('logo'))->save();
            /* redirect to Index page with Success Message */
            return redirect('getcompany')->with('success', Lang::get('lang.company_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getcompany')->with('fails', Lang::get('lang.company_can_not_updated').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * function to delete system logo.
     *
     *  @return type string
     */
    public function deleteLogo()
    {
        $path = $_GET['data1']; //get file path of logo image
        if (!unlink($path)) {
            return 'false';
        } else {
            $companys = Company::where('id', '=', 1)->first();
            $companys->logo = null;
            $companys->use_logo = '0';
            $companys->save();

            return 'true';
        }
        // return $res;
    }

    /**
     * get the form for System setting page.
     *
     * @param type System           $system
     * @param type Department       $department
     * @param type Timezones        $timezone
     * @param type Date_format      $date
     * @param type Date_time_format $date_time
     * @param type Time_format      $time
     *
     * @return type Response
     */
    public function getsystem(System $system, Department $department, Timezones $timezone, Date_format $date, Date_time_format $date_time, Time_format $time, CommonSettings $common_settings)
    {
        try {
            /* fetch the values of system from system table */
            $systems = $system->whereId('1')->first();
            /* Fetch the values from Department table */
            $departments = $department->get();
            /* Fetch the values from Timezones table */
            $timezones = $timezone->pluck('name', 'name')->toArray();
            /* Fetch status value of common settings */
            $common_setting = $common_settings->select('status')
                    ->where('option_name', '=', 'user_set_ticket_status')
                    ->first();
            $send_otp = $common_settings->select('status')
                    ->where('option_name', '=', 'send_otp')
                    ->first();
            $email_mandatory = $common_settings->select('status')
                    ->where('option_name', '=', 'email_mandatory')
                    ->first();
            $formats = $date_time->pluck('format', 'format')->merge(['custom'=>'Custom', 'human-read'=>'Human readable'])->toArray();
            
            $common = new CommonSettings();
            $verify = $common->getOptionValue('verify','verify');
            $verify_decode = ['email'=>'','mobile'=>''];
            if($verify->count()>0){
                $verify_decode = json_decode($verify->option_value,true);
            }
            
            /* Direct to System Settings Page */
            return view('themes.default1.admin.helpdesk.settings.system', compact('systems', 'departments', 'timezones', 'time', 'date', 'date_time', 'common_setting', 'send_otp', 'email_mandatory', 'formats','verify_decode'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int           $id
     * @param type System        $system
     * @param type SystemRequest $request
     *
     * @return type Response
     */
    public function postsystem($id, System $system, SystemRequest $request)
    {
        try {
            /* fetch the values of system request  */
            $systems = $system->whereId('1')->first();
            /* fill the values to coompany table */
            /* Check whether function success or not */
            $systems->fill($request->input())->save();
            $rtl = CommonSettings::where('option_name', '=', 'enable_rtl')->first();
            if ($request->enable_rtl != null) {
                $rtl->option_value = 1;
            } else {
                $rtl->option_value = 0;
            }
            $rtl->save();

            $usts = CommonSettings::where('option_name', '=', 'user_set_ticket_status')->first();
            if ($usts->status != $request->user_set_ticket_status) {
                $usts->status = $request->user_set_ticket_status;
                $usts->save();
            }
            $sotp = CommonSettings::where('option_name', '=', 'send_otp')
                    ->update(['status' => $request->send_otp]);
            $email_mandatory = CommonSettings::where('option_name', '=', 'email_mandatory')
                    ->update(['status' => $request->email_mandatory]);

            if ($request->has('itil')) {
                $itil = $request->input('itil');
                $sett = CommonSettings::firstOrCreate(['option_name'=>'itil']);
                $sett->status = $itil;
                $sett->save();
            }
            if ($request->has('verify')) {
                $json = json_encode($request->input('verify'));
                CommonSettings::updateOrCreate(['option_name' => 'verify'],['option_value'=>$json,'optional_field'=>'verify']);
            }
            /* redirect to Index page with Success Message */
            return redirect('getsystem')->with('success', Lang::get('lang.system_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getsystem')->with('fails', Lang::get('lang.system_can_not_updated').'<br>'.$e->getMessage());
        }
    }

    /**
     * get the form for Ticket setting page.
     *
     * @param type Ticket     $ticket
     * @param type Sla_plan   $sla
     * @param type Help_topic $topic
     * @param type Priority   $priority
     *
     * @return type Response
     */
    public function getticket(Ticket $ticket, Sla_plan $sla, Help_topic $topic, Ticket_Priority $priority)
    {
        try {
            /* fetch the values of ticket from ticket table */
            $tickets = $ticket->whereId('1')->first();
            /* Fetch the values from SLA Plan table */
            $slas = $sla->get();
            /* Fetch the values from Help_topic table */
            $topics = $topic->get();
            /* Direct to Ticket Settings Page */
            return view('themes.default1.admin.helpdesk.settings.ticket', compact('tickets', 'slas', 'topics', 'priority'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified Ticket in storage.
     *
     * @param type int     $id
     * @param type Ticket  $ticket
     * @param type Request $request
     *
     * @return type Response
     */
    public function postticket($id, Ticket $ticket, Request $request)
    {
        try {
            /* fetch the values of ticket request  */
            $tickets = $ticket->whereId('1')->first();
            /* fill the values to coompany table */
            $tickets->fill($request->except('captcha', 'claim_response', 'assigned_ticket', 'answered_ticket', 'agent_mask', 'html', 'client_update'))->save();
            /* insert checkbox to Database  */
            $tickets->captcha = $request->input('captcha');
            $tickets->claim_response = $request->input('claim_response');
            $tickets->assigned_ticket = $request->input('assigned_ticket');
            $tickets->answered_ticket = $request->input('answered_ticket');
            $tickets->agent_mask = $request->input('agent_mask');
            $tickets->html = $request->input('html');
            $tickets->client_update = $request->input('client_update');
            $tickets->collision_avoid = $request->input('collision_avoid');
            /* Check whether function success or not */
            $tickets->save();
            /* redirect to Index page with Success Message */
            return redirect('getticket')->with('success', Lang::get('lang.ticket_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getticket')->with('fails', Lang::get('lang.ticket_can_not_updated').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * get the form for Email setting page.
     *
     * @param type Email    $email
     * @param type Template $template
     * @param type Emails   $email1
     *
     * @return type Response
     */
    public function getemail(Email $email, Template $template, Emails $email1)
    {
        try {
            /* fetch the values of email from Email table */
            $emails = $email->whereId('1')->first();
            /* Fetch the values from Template table */
            $templates = $template->get();
            /* Fetch the values from Emails table */
            $emails1 = $email1->get();
            /* Direct to Email Settings Page */
            return view('themes.default1.admin.helpdesk.settings.email', compact('emails', 'templates', 'emails1'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified email setting in storage.
     *
     * @param type int          $id
     * @param type Email        $email
     * @param type EmailRequest $request
     *
     * @return type Response
     */
    public function postemail($id, Email $email, EmailRequest $request)
    {
        try {
            /* fetch the values of email request  */
            $emails = $email->whereId('1')->first();
            /* fill the values to email table */
            $emails->fill($request->except('email_fetching', 'all_emails', 'email_collaborator', 'strip', 'attachment'))->save();
            /* insert checkboxes  to database */
            // $emails->email_fetching = $request->input('email_fetching');
            // $emails->notification_cron = $request->input('notification_cron');
            $emails->all_emails = $request->input('all_emails');
            $emails->email_collaborator = $request->input('email_collaborator');
            $emails->strip = $request->input('strip');
            $emails->attachment = $request->input('attachment');
            /* Check whether function success or not */
            $emails->save();
            /* redirect to Index page with Success Message */
            return redirect('getemail')->with('success', Lang::get('lang.email_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getemail')->with('fails', Lang::get('lang.email_can_not_updated').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * get the form for cron job setting page.
     *
     * @param type Email    $email
     * @param type Template $template
     * @param type Emails   $email1
     *
     * @return type Response
     */
    public function getSchedular(Email $email, Template $template, Emails $email1, WorkflowClose $workflow)
    {
        // try {
        /* fetch the values of email from Email table */
        $emails = $email->whereId('1')->first();
        /* Fetch the values from Template table */
        $templates = $template->get();
        /* Fetch the values from Emails table */
        $emails1 = $email1->get();

        $workflow = $workflow->whereId('1')->first();
        $cron_path = base_path('artisan');
        $command = ":- <pre>***** php $cron_path schedule:run >> /dev/null 2>&1</pre>";
        $shared = ":- <pre>/usr/bin/php-cli -q  $cron_path schedule:run >> /dev/null 2>&1</pre>";
        $warn = '';
        $condition = new \App\Model\MailJob\Condition();
        $job = $condition->checkActiveJob();
        $commands = [
            ''                   => 'Select',
            'everyMinute'        => 'Every Minute',
            'everyFiveMinutes'   => 'Every Five Minute',
            'everyTenMinutes'    => 'Every Ten Minute',
            'everyThirtyMinutes' => 'Every Thirty Minute',
            'hourly'             => 'Every Hour',
            'daily'              => 'Every Day',
            'dailyAt'            => 'Daily at',
            'weekly'             => 'Every Week',
            'monthly'            => 'Monthly',
            'yearly'             => 'Yearly',
        ];
        $followupcommands = [
            ''                   => 'Select',
            'everyMinute'        => 'Every Minute',
            'everyFiveMinutes'   => 'Every Five Minute',
            'everyTenMinutes'    => 'Every Ten Minute',
            'everyThirtyMinutes' => 'Every Thirty Minute',
            'hourly'             => 'Every Hour',
            'daily'              => 'Every Day',
            'weekly'             => 'Every Week',
            'monthly'            => 'Monthly',
            'yearly'             => 'Yearly',
        ];
        if (ini_get('register_argc_argv') == '') {
            //$warn = "Please make 'register_argc_argv' flag as on. Or you can set all your job url in cron";
        }

        return view('themes.default1.admin.helpdesk.settings.cron.cron', compact('emails', 'templates', 'emails1', 'workflow', 'warn', 'command', 'commands', 'followupcommands', 'condition', 'shared'));
        // } catch {
        // }
    }

    /**
     * Update the specified schedular in storage for cron job.
     *
     * @param type Email        $email
     * @param type EmailRequest $request
     *
     * @return type Response
     */
    public function postSchedular(Email $email, Template $template, Emails $email1, TaskRequest $request, WorkflowClose $workflow)
    {
        try {
            /* fetch the values of email request  */
            $emails = $email->whereId('1')->first();
            if ($request->email_fetching) {
                $emails->email_fetching = $request->email_fetching;
            } else {
                $emails->email_fetching = 0;
            }
            if ($request->notification_cron) {
                $emails->notification_cron = $request->notification_cron;
            } else {
                $emails->notification_cron = 0;
            }
            $emails->save();
            //workflow
            $work = $workflow->whereId('1')->first();
            if ($request->condition) {
                $work->condition = 1;
            } else {
                $work->condition = 0;
            }
            $work->save();
            $this->saveConditions();
            /* redirect to Index page with Success Message */
            return redirect('job-scheduler')->with('success', Lang::get('lang.job-scheduler-success'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('job-scheduler')->with('fails', Lang::get('lang.job-scheduler-error').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * get the form for Responder setting page.
     *
     * @param type Responder $responder
     *
     * @return type Response
     */
    public function getresponder(Responder $responder)
    {
        try {
            /* fetch the values of responder from responder table */
            $responders = $responder->whereId('1')->first();
            /* Direct to Responder Settings Page */
            return view('themes.default1.admin.helpdesk.settings.responder', compact('responders'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified autoresponse in storage.
     *
     * @param type Responder $responder
     * @param type Request   $request
     *
     * @return type
     */
    public function postresponder(Responder $responder, Request $request)
    {
        try {
            /* fetch the values of responder request  */
            $responders = $responder->whereId('1')->first();
            /* insert Checkbox value to DB */
            $responders->new_ticket = $request->input('new_ticket');
            $responders->agent_new_ticket = $request->input('agent_new_ticket');
            $responders->submitter = $request->input('submitter');
            $responders->participants = $request->input('participants');
            $responders->overlimit = $request->input('overlimit');
            /* fill the values to coompany table */
            /* Check whether function success or not */
            $responders->save();
            /* redirect to Index page with Success Message */
            return redirect('getresponder')->with('success', Lang::get('lang.auto_response_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getresponder')->with('fails', Lang::get('lang.auto_response_can_not_updated').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * get the form for Alert setting page.
     *
     * @param type Alert $alert
     *
     * @return type Response
     */
    public function getalert(Alert $alerts)
    {
        try {
            return view('themes.default1.admin.helpdesk.settings.alert', compact('alerts'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified alert in storage.
     *
     * @param type         $id
     * @param type Alert   $alert
     * @param type Request $request
     *
     * @return type Response
     */
    public function postalert(Alert $alert, Request $request)
    {
        try {
            $requests = $request->except('_token');
            Alert::truncate();
            foreach ($requests as $key => $value) {
                if (is_array($value)) {
                    $value = implode(',', $value);
                }
                Alert::create([
                    'key'   => $key,
                    'value' => $value,
                ]);
            }

            return redirect('alert')->with('success', Lang::get('lang.alert_&_notices_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('alert')->with('fails', $e->getMessage());
        }
    }

    /**
     *  Generate Api key.
     *
     *  @return type json
     */
    public function generateApiKey()
    {
        $key = str_random(32);

        return $key;
    }

    /**
     * Main Settings Page.
     *
     * @return type view
     */
    public function settings()
    {
        return view('themes.default1.admin.helpdesk.setting');
    }

    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function getStatuses()
    {
        try {
            /* fetch the values of company from company table */
            $statuss = \DB::table('ticket_status')->get();
            /* Direct to Company Settings Page */
            return view('themes.default1.admin.helpdesk.settings.status', compact('statuss'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function getEditStatuses($id)
    {
        try {
            /* fetch the values of company from company table */
            $status = \DB::table('ticket_status')->where('id', '=', $id)->first();
            /* Direct to Company Settings Page */
            return view('themes.default1.admin.helpdesk.settings.status-edit', compact('status'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function editStatuses($id, StatusRequest $request)
    {
        try {
            /* fetch the values of company from company table */
            $statuss = \App\Model\helpdesk\Ticket\Ticket_Status::whereId($id)->first();
            $statuss->name = $request->input('name');
            $statuss->icon_class = $request->input('icon_class');
            $statuss->email_user = $request->input('email_user');
            $statuss->sort = $request->input('sort');
            $delete = $request->input('deleted');
            if ($delete == 'yes') {
                $statuss->state = 'delete';
            } else {
                $statuss->state = $request->input('state');
            }
            $statuss->sort = $request->input('sort');
            $statuss->save();
            /* Direct to Company Settings Page */
            return redirect()->back()->with('success', Lang::get('lang.status_has_been_updated_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * create a status.
     *
     * @param \App\Model\helpdesk\Ticket\Ticket_Status  $statuss
     * @param \App\Http\Requests\helpdesk\StatusRequest $request
     *
     * @return type redirect
     */
    public function createStatuses(\App\Model\helpdesk\Ticket\Ticket_Status $statuss, StatusRequest $request)
    {
        try {
            /* fetch the values of company from company table */
            $statuss->name = $request->input('name');
            $statuss->icon_class = $request->input('icon_class');
            $statuss->email_user = $request->input('email_user');
            $statuss->sort = $request->input('sort');
            $delete = $request->input('delete');
            if ($delete == 'yes') {
                $statuss->state = 'deleted';
            } else {
                $statuss->state = $request->input('state');
            }
            $statuss->sort = $request->input('sort');
            $statuss->save();
            /* Direct to Company Settings Page */
            return redirect()->back()->with('success', Lang::get('lang.status_has_been_created_successfully'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * delete a status.
     *
     * @param type $id
     *
     * @return type redirect
     */
    public function deleteStatuses($id)
    {
        try {
            if ($id > 5) {
                /* fetch the values of company from company table */
                \App\Model\helpdesk\Ticket\Ticket_Status::whereId($id)->delete();
                /* Direct to Company Settings Page */
                return redirect()->back()->with('success', Lang::get('lang.status_has_been_deleted'));
            } else {
                return redirect()->back()->with('failed', Lang::get('lang.you_cannot_delete_this_status'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * get the page of notification settings.
     *
     * @return type view
     */
    public function notificationSettings()
    {
        return view('themes.default1.admin.helpdesk.settings.notification');
    }

    /**
     * delete a notification.
     *
     * @return type redirect
     */
    public function deleteReadNoti()
    {
        $markasread = UserNotification::where('is_read', '=', 1)->get();
        foreach ($markasread as $mark) {
            $mark->delete();
            \App\Model\helpdesk\Notification\Notification::whereId($mark->notification_id)->delete();
        }

        return redirect()->back()->with('success', Lang::get('lang.you_have_deleted_all_the_read_notifications'));
    }

    /**
     * delete a notification log.
     *
     * @return type redirect
     */
    public function deleteNotificationLog()
    {
        $days = Input::get('no_of_days');
        if ($days == null) {
            return redirect()->back()->with('fails', 'Please enter valid no of days');
        }
        $date = new DateTime();
        $date->modify($days.' day');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $markasread = UserNotification::where('created_at', '<=', $formatted_date)->get();
        foreach ($markasread as $mark) {
            $mark->delete();
            \App\Model\helpdesk\Notification\Notification::whereId($mark->notification_id)->delete();
        }

        return redirect()->back()->with('success', Lang::get('lang.you_have_deleted_all_the_notification_records_since').$days.' days.');
    }

    /**
     *  To display the list of ratings in the system.
     *
     *  @return type View
     */
    public function RatingSettings()
    {
        try {
            $ratings = Rating::orderBy('display_order', 'asc')->get();

            return view('themes.default1.admin.helpdesk.settings.ratings', compact('ratings'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * edit a rating.
     *
     * @param type $id
     *
     * @return type view
     */
    public function editRatingSettings($id)
    {
        try {
            $rating = Rating::whereId($id)->first();

            return view('themes.default1.admin.helpdesk.settings.edit-ratings', compact('rating'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     *  To store rating data.
     *
     *  @return type Redirect
     */
    public function PostRatingSettings($id, Rating $ratings, RatingUpdateRequest $request)
    {
        try {
            $rating = $ratings->whereId($id)->first();
            $rating->name = $request->input('name');
            $rating->display_order = $request->input('display_order');
            $rating->allow_modification = $request->input('allow_modification');
            $rating->rating_scale = $request->input('rating_scale');
//            $rating->rating_area = $request->input('rating_area');
            $rating->restrict = $request->input('restrict');
            $rating->save();

            return redirect()->back()->with('success', Lang::get('lang.ratings_updated_successfully'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * get the create rating page.
     *
     * @return type redirect
     */
    public function createRating()
    {
        try {
            return view('themes.default1.admin.helpdesk.settings.create-ratings');
        } catch (Exception $ex) {
            return redirect('getratings')->with('fails', Lang::get('lang.ratings_can_not_be_created').'<li>'.$ex->getMessage().'</li>');
        }
    }

    /**
     * store a rating value.
     *
     * @param \App\Model\helpdesk\Ratings\Rating        $rating
     * @param \App\Model\helpdesk\Ratings\RatingRef     $ratingrefs
     * @param \App\Http\Requests\helpdesk\RatingRequest $request
     *
     * @return type redirect
     */
    public function storeRating(Rating $rating, \App\Model\helpdesk\Ratings\RatingRef $ratingrefs, \App\Http\Requests\helpdesk\RatingRequest $request)
    {
        $rating->name = $request->input('name');
        $rating->display_order = $request->input('display_order');
        $rating->allow_modification = $request->input('allow_modification');
        $rating->rating_scale = $request->input('rating_scale');
        $rating->rating_area = $request->input('rating_area');
        $rating->restrict = $request->input('restrict');
        $rating->save();
        $ratingrefs->rating_id = $rating->id;
        $ratingrefs->save();

        return redirect()->back()->with('success', Lang::get('lang.successfully_created_this_rating'));
    }

    /**
     *  To delete a type of rating.
     *
     *  @return type Redirect
     */
    public function RatingDelete($slug, \App\Model\helpdesk\Ratings\RatingRef $ratingrefs)
    {
        $ratingrefs->where('rating_id', '=', $slug)->delete();
        Rating::whereId($slug)->delete();

        return redirect()->back()->with('success', Lang::get('lang.rating_deleted_successfully'));
    }

    public function saveConditions()
    {
        if (\Input::get('fetching-commands') && \Input::get('notification-commands')) {
            $fetching_commands = \Input::get('fetching-commands');
            $fetching_dailyAt = \Input::get('fetching-dailyAt');
            $notification_commands = \Input::get('notification-commands');
            $notification_dailyAt = \Input::get('notification-dailyAt');
            $work_commands = \Input::get('work-commands');
            $workflow_dailyAt = \Input::get('workflow-dailyAt');
            $fetching_command = $this->getCommand($fetching_commands, $fetching_dailyAt);
            $notification_command = $this->getCommand($notification_commands, $notification_dailyAt);
            $work_command = $this->getCommand($work_commands, $workflow_dailyAt);
            $jobs = ['fetching'=>$fetching_command, 'notification'=>$notification_command, 'work'=>$work_command];
            $this->storeCommand($jobs);
        }
    }

    public function getCommand($command, $daily_at)
    {
        if ($command == 'dailyAt') {
            $command = "dailyAt,$daily_at";
        }

        return $command;
    }

    public function storeCommand($array = [])
    {
        $command = new \App\Model\MailJob\Condition();
        $commands = $command->get();
        if ($commands->count() > 0) {
            foreach ($commands as $condition) {
                $condition->delete();
            }
        }
        if (count($array) > 0) {
            foreach ($array as $key=>$save) {
                $command->create([
                    'job'  => $key,
                    'value'=> $save,
                ]);
            }
        }
    }

    public function getTicketNumber(Request $request)
    {
        $this->validate($request, [
            'format' => ['required', 'regex:/^(?=.*[$|-|#]).+$/'],
            'type'   => 'required',
        ]);

        $format = $request->input('format');
        $type = $request->input('type');
        $number = $this->switchNumber($format, $type);

        return $number;
    }

    public function switchNumber($format, $type)
    {
        switch ($type) {
            case 'random':
                return $this->createRandomNumber($format);
            case 'sequence':
                return $this->createSequencialNumber($format);
        }
    }

    public function createRandomNumber($format)
    {
        $number = '';
        $array = str_split($format);
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] === '$') {
                $number .= $this->getRandomAlphebet();
            }
            if ($array[$i] === '#') {
                $number .= rand(0, 9);
            }
            if ($array[$i] !== '$' && $array[$i] !== '#') {
                $number .= $array[$i];
            }
        }

        return $number;
    }

    public function createSequencialNumber($format)
    {
        $number = '';
        $array_format = str_split($format);
        $count = count($array_format);
        for ($i = 0; $i < $count; $i++) {
            //dd($sub);
            if ($array_format[$i] === '$') {
                $number .= 'A';
            }

            if ($array_format[$i] === '#') {
                $number .= '0';
            }

            if ($array_format[$i] !== '$' && $array_format[$i] !== '#') {
                $number .= $array_format[$i];
            }
        }

        return $number;
        //return $this->nthTicketNumber($number);
    }

    public function checkCurrentFormat($current, $format)
    {
        $check = true;
        $array_current = str_split($current);
        $array_format = str_split($format);
        $count_current = count($array_current);
        $count_format = count($array_format);
        if ($count_current === $count_format) {
            return false;
        }
        for ($i = 0; $i < $count_current; $i++) {
            if ($array_current[$i] !== $array_format[$i]) {
                return false;
            }
        }

        return $check;
    }

    public function nthTicketNumber($current, $type, $format, $force = false)
    {
        $check = $this->checkCurrentFormat($current, $format);
        if ($check === false && $force === false) {
            $current = $this->createSequencialNumber($format);
        }
        if ($type === 'sequence') {
            $pos_first = stripos($current, '-');
            $pos_last = strpos($current, '-', $pos_first + 1);
            $current = str_replace('-', '', $current);
            $number = ++$current;
            if ($pos_first) {
                $number = substr_replace($number, '-', $pos_first, 0);
            }
            if ($pos_last) {
                $number = substr_replace($number, '-', $pos_last, 0);
            }
        }
        if ($type === 'random') {
            $number = $this->createRandomNumber($format);
        }

        return $number;
    }

    public function getRandomAlphebet()
    {
        $alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffled = str_shuffle($alpha);
        $shuffled_array = str_split($shuffled);
        $char = $shuffled_array[0];

        return $char;
    }
}
