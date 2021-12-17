<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\HelptopicRequest;
use App\Http\Requests\helpdesk\HelptopicUpdate;
// models
use App\Model\helpdesk\Agent\Agents;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Form\Forms;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\User;
// classes
use DB;
use Exception;
use Lang;

/**
 * HelptopicController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class HelptopicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type vodi
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * Display a listing of the helptopic.
     *
     * @param type Help_topic $topic
     *
     * @return type Response
     */
    public function index(Help_topic $topic)
    {
        try {
            $topics = $topic->get();

            return view('themes.default1.admin.helpdesk.manage.helptopic.index', compact('topics'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new helptopic.
     *
     * @param type Priority   $priority
     * @param type Department $department
     * @param type Help_topic $topic
     * @param type Form_name  $form
     * @param type Agents     $agent
     * @param type Sla_plan   $sla
     *
     * @return type Response
     */
    /*
      ================================================
      | Route to Create view file passing Model Values
      | 1.Department Model
      | 2.Help_topic Model
      | 3.Agents Model
      | 4.Sla_plan Model
      | 5.Forms Model
      ================================================
     */
    public function create(Ticket_Priority $priority, Department $department, Help_topic $topic, Forms $form, User $agent, Sla_plan $sla)
    {
        try {
            $departments = $department->get();
            $topics = $topic->get();
            $forms = $form->get();
            $agents = $agent->where('role', '!=', 'user')->where('active', '=', 1)->orderBy('first_name')->get();
            $slas = $sla->get();
            $priority = Ticket_Priority::where('status', '=', 1)->get();

            return view('themes.default1.admin.helpdesk.manage.helptopic.create', compact('priority', 'departments', 'topics', 'forms', 'agents', 'slas'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Store a newly created helptpoic in storage.
     *
     * @param type Help_topic       $topic
     * @param type HelptopicRequest $request
     *
     * @return type Response
     */
    public function store(Help_topic $topic, HelptopicRequest $request)
    {
        try {
            if ($request->custom_form) {
                $custom_form = $request->custom_form;
            } else {
                $custom_form = null;
            }
            if ($request->auto_assign) {
                $auto_assign = $request->auto_assign;
            } else {
                $auto_assign = null;
            }
            /* Check whether function success or not */
            $topic->fill($request->except('custom_form', 'auto_assign'))->save();
            // $topics->fill($request->except('custom_form','auto_assign'))->save();
            /* redirect to Index page with Success Message */
            return redirect('helptopic')->with('success', Lang::get('lang.helptopic_created_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('helptopic')->with('fails', Lang::get('lang.helptopic_can_not_create').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * Show the form for editing the specified helptopic.
     *
     * @param type $id
     * @param type Priority   $priority
     * @param type Department $department
     * @param type Help_topic $topic
     * @param type Form_name  $form
     * @param type Agents     $agent
     * @param type Sla_plan   $sla
     *
     * @return type Response
     */
    public function edit($id, Ticket_Priority $priority, Department $department, Help_topic $topic, Forms $form, Sla_plan $sla)
    {
        try {
            $agents = User::where('role', '!=', 'user')->where('active', '=', 1)->orderBy('first_name')->get();
            $departments = $department->get();
            $topics = $topic->whereId($id)->first();
            $forms = $form->get();
            $slas = $sla->get();
            $priority = Ticket_Priority::where('status', '=', 1)->get();
            $sys_help_topic = \DB::table('settings_ticket')
                                ->select('help_topic')
                                ->where('id', '=', 1)->first();

            return view('themes.default1.admin.helpdesk.manage.helptopic.edit', compact('priority', 'departments', 'topics', 'forms', 'agents', 'slas', 'sys_help_topic'));
        } catch (Exception $e) {
            return redirect('helptopic')->with('fails', '<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * Update the specified helptopic in storage.
     *
     * @param type $id
     * @param type Help_topic      $topic
     * @param type HelptopicUpdate $request
     *
     * @return type Response
     */
    public function update($id, Help_topic $topic, HelptopicUpdate $request)
    {
        try {
            $topics = $topic->whereId($id)->first();
            if ($request->custom_form) {
                $custom_form = $request->custom_form;
            } else {
                $custom_form = null;
            }
            if ($request->auto_assign) {
                $auto_assign = $request->auto_assign;
            } else {
                $auto_assign = null;
            }
            /* Check whether function success or not */
            $topics->fill($request->except('custom_form', 'auto_assign'))->save();
            $topics->custom_form = $custom_form;
            $topics->auto_assign = $auto_assign;
            $topics->save();
            if ($request->input('sys_help_tpoic') == 'on') {
                \DB::table('settings_ticket')
                    ->where('id', '=', 1)
                    ->update(['help_topic' => $id]);
            }
            /* redirect to Index page with Success Message */
            return redirect('helptopic')->with('success', Lang::get('lang.helptopic_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('helptopic')->with('fails', Lang::get('lang.helptopic_can_not_update').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * Remove the specified helptopic from storage.
     *
     * @param type int        $id
     * @param type Help_topic $topic
     *
     * @return type Response
     */
    public function destroy($id, Help_topic $topic, Ticket $ticket_setting)
    {
        $ticket_settings = $ticket_setting->where('id', '=', '1')->first();
        if ($ticket_settings->help_topic == $id) {
            return redirect('departments')->with('fails', Lang::get('lang.you_cannot_delete_default_department'));
        } else {
            $tickets = DB::table('tickets')->where('help_topic_id', '=', $id)->update(['help_topic_id' => $ticket_settings->help_topic]);
            if ($tickets > 0) {
                if ($tickets > 1) {
                    $text_tickets = 'Tickets';
                } else {
                    $text_tickets = 'Ticket';
                }
                $ticket = '<li>'.$tickets.' '.$text_tickets.Lang::get('lang.have_been_moved_to_default_help_topic').' </li>';
            } else {
                $ticket = '';
            }
            $emails = DB::table('emails')->where('help_topic', '=', $id)->update(['help_topic' => $ticket_settings->help_topic]);
            if ($emails > 0) {
                if ($emails > 1) {
                    $text_emails = 'Emails';
                } else {
                    $text_emails = 'Email';
                }
                $email = '<li>'.$emails.' System '.$text_emails.Lang::get('lang.have_been_moved_to_default_help_topic').' </li>';
            } else {
                $email = '';
            }
            $message = $ticket.$email;
            $topics = $topic->whereId($id)->first();
            /* Check whether function success or not */
            try {
                $topics->delete();
                /* redirect to Index page with Success Message */
                return redirect('helptopic')->with('success', Lang::get('lang.helptopic_deleted_successfully').$message);
            } catch (Exception $e) {
                /* redirect to Index page with Fails Message */
                return redirect('helptopic')->with('fails', Lang::get('lang.helptopic_can_not_update').'<li>'.$e->getMessage().'</li>');
            }
        }
    }
}
