<?php

namespace App\Http\Controllers\Client\helpdesk;

// controllers
use App\Http\Controllers\Agent\helpdesk\TicketWorkflowController;
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\ClientRequest;
use App\Model\helpdesk\Agent\Department;
// models
use App\Model\helpdesk\Form\Fields;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Settings\CommonSettings;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Utility\CountryCode;
use App\User;
use Exception;
// classes
use Form;
use GeoIP;
use Illuminate\Http\Request;
use Input;
use Lang;
use Redirect;

/**
 * FormController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class FormController extends Controller
{
    /**
     * Create a new controller instance.
     * Constructor to check.
     *
     * @return void
     */
    public function __construct(TicketWorkflowController $TicketWorkflowController)
    {
        $this->middleware('board');
        // creating a TicketController instance
        $this->TicketWorkflowController = $TicketWorkflowController;
    }

    /**
     * getform.
     *
     * @param type Help_topic $topic
     *
     * @return type
     */
    public function getForm(Help_topic $topic, CountryCode $code)
    {
        if (\Config::get('database.install') == '%0%') {
            return \Redirect::route('licence');
        }
        $settings = CommonSettings::select('status')->where('option_name', '=', 'send_otp')->first();
        $email_mandatory = CommonSettings::select('status')->where('option_name', '=', 'email_mandatory')->first();
        if (!\Auth::check() && ($settings->status == 1 || $settings->status == '1')) {
            return redirect('auth/login')->with(['login_require' => 'Please login to your account for submitting a ticket', 'referer' => 'form']);
        }
        $location = GeoIP::getLocation();
        $phonecode = $code->where('iso', '=', $location->iso_code)->first();
        if (System::first()->status == 1) {
            $topics = $topic->get();
            $codes = $code->get();
            if ($phonecode->phonecode) {
                $phonecode = $phonecode->phonecode;
            } else {
                $phonecode = '';
            }

            return view('themes.default1.client.helpdesk.form', compact('topics', 'codes', 'email_mandatory'))->with('phonecode', $phonecode);
        } else {
            return \Redirect::route('home');
        }
    }

    /**
     * This Function to post the form for the ticket.
     *
     * @param type Form_name    $name
     * @param type Form_details $details
     *
     * @return type string
     */
    public function postForm($id, Help_topic $topic)
    {
        if ($id != 0) {
            $helptopic = $topic->where('id', '=', $id)->first();
            $custom_form = $helptopic->custom_form;
            $values = Fields::where('forms_id', '=', $custom_form)->get();
            if (!$values) {
            }
            if ($values) {
                foreach ($values as $form_data) {
                    if ($form_data->type == 'select') {
                        $form_fields = explode(',', $form_data->value);
                        $var = '';
                        foreach ($form_fields as $form_field) {
                            $var .= '<option value="'.$form_field.'">'.$form_field.'</option>';
                        }
                        echo '<br/><label>'.ucfirst($form_data->label).'</label><select class="form-control" name="'.$form_data->name.'">'.$var.'</select>';
                    } elseif ($form_data->type == 'radio') {
                        $type2 = $form_data->value;
                        $vals = explode(',', $type2);
                        echo '<br/><label>'.ucfirst($form_data->label).'</label><br/>';
                        foreach ($vals as $val) {
                            echo '<input type="'.$form_data->type.'" name="'.$form_data->name.'"> '.$form_data->value.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                        echo '<br/>';
                    } elseif ($form_data->type == 'textarea') {
                        $type3 = $form_data->value;
                        echo '<br/><label>'.$form_data->label.'</label></br><textarea id="unique-textarea" name="'.$form_data->name.'" class="form-control" style="height:15%;"></textarea>';
                    } elseif ($form_data->type == 'checkbox') {
                        $type4 = $form_data->value;
                        $checks = explode(',', $type4);
                        echo '<br/><label>'.ucfirst($form_data->label).'</label><br/>';
                        foreach ($checks as $check) {
                            echo '<input type="'.$form_data->type.'" name="'.$form_data->name.'">&nbsp&nbsp'.$check;
                        }
                    } else {
                        echo '<br/><label>'.ucfirst($form_data->label).'</label><input type="'.$form_data->type.'" class="form-control"   name="'.$form_data->name.'" />';
                    }
                }
                echo '<br/><br/>';
            }
        } else {
            return;
        }
    }

    /**
     * Posted form.
     *
     * @param type Request $request
     * @param type User    $user
     */
    public function postedForm(User $user, ClientRequest $request, Ticket $ticket_settings, Ticket_source $ticket_source, Ticket_attachments $ta, CountryCode $code)
    {
        try {
            $phone = '';
            $collaborator = null;
            $auto_response = 0;
            $team_assign = null;
            $sla = '';
            $email = null;
            $name = null;
            $mobile_number = null;
            $phonecode = '';
            $user = '';
            $default_values = ['Requester', 'Requester_email', 'Requester_name', 'media_option',
                'Requester_mobile', 'Help_Topic', 'cc', 'Help Topic',
                'Requester_mobile', 'Requester_code', 'Help Topic', 'Assigned', 'Subject',
                'subject', 'priority', 'help_topic', 'body', 'Description', 'Priority',
                'Type', 'Status', 'attachment', 'inline', 'email', 'first_name',
                'last_name', 'mobile', 'country_code', 'api', 'sla', 'dept', 'code',
                'user_id', 'media_attachment', 'requester', 'status', 'assigned', 'description', 'type', 'media_option', 'Department', 'department', ];
            $form_extras = $request->except($default_values);
            $requester = $request->input('requester');
            $user = false;
            if ($request->has('requester')) {
                $user = User::find($requester);
            }
            if ($request->has('email')) {
                $email = $request->input('email');
            } elseif ($user) {
                $email = $user->email;
            }
            if ($request->has('full_name')) {
                $name = $request->input('full_name');
            } elseif ($user) {
                $name = $user->first_name;
            }
            if ($request->has('mobile')) {
                $mobile_number = $request->input('mobile');
            } elseif ($user) {
                $mobile_number = $user->mobile;
            }
            if ($request->has('code')) {
                $phonecode = $request->input('code');
            } elseif ($user) {
                $phonecode = $user->country_code;
            }
            if (!$phonecode) {
                $phonecode = '';
            }
            if ($request->has('help_topic')) {
                $helptopic = $request->input('help_topic');
                $help = Help_topic::where('id', '=', $helptopic)->first();
            } else {
                $help = Help_topic::first();
                $helptopic = $help->id;
            }
            if ($request->has('assigned')) {
                $assignto = $request->input('assigned');
            } else {
                $assignto = null;
            }
            if ($request->has('subject')) {
                $subject = $request->input('subject');
            } else {
                $subject = null;
            }
            if ($request->has('description')) {
                $details = $request->input('description');
            } else {
                $details = null;
            }
            if ($request->has('priority')) {
                $priority = $request->input('priority');
            } else {
                $priority = null;
            }
            if ($request->input('type')) {
                $type = $request->input('type');
            } else {
                $default_type = Tickettype::where('is_default', '>', 0)->select('id')->first();
                $type = $default_type->id;
            }
            if ($request->input('status')) {
                $status = $ticket_settings->first()->status;
            } else {
                $status = null;
            }
            $company = '';
            if ($request->has('company')) {
                $company = $request->input('company');
            }

            $source = Ticket_source::where('name', '=', 'web')->first()->id;
            $attach = [];
            $media_attach = [];
            if ($request->has('media_attachment')) {
                $media_attach = $request->input('media_attachment');
            }
            if ($request->file()) {
                $attach = $request->file();
            }
            $department = ($request->has('department')) ? $request->input('department') : $help->department;
            $attachment = array_merge($attach, $media_attach);
            \Event::fire(new \App\Events\ClientTicketFormPost($form_extras, $email, $source));
            $respnse = $this->TicketWorkflowController->workflow($email, $name, $subject, $details, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $collaborator, $department, $assignto, $team_assign, $status, $form_extras, $auto_response, $type, $attachment, [], [], $company);
        } catch (\Exception $e) {
            $result = $e->getMessage();

            return response()->json(compact('result'), 500);
        }
        $msg = Lang::get('lang.Ticket-has-been-created-successfully-your-ticket-number-is').' '.$respnse[0].'. '.Lang::get('lang.Please-save-this-for-future-reference');
        $result = ['success' => $msg];

        return response()->json(compact('result'));
    }

    /**
     * reply.
     *
     * @param type $value
     *
     * @return type view
     */
    public function post_ticket_reply($id, Request $request)
    {
        try {
            if ($comment != null) {
                $tickets = Tickets::where('id', '=', $id)->first();
                $thread = Ticket_Thread::where('ticket_id', '=', $tickets->id)->first();

                $subject = $thread->title.'[#'.$tickets->ticket_number.']';
                $body = $request->input('comment');

                $user_cred = User::where('id', '=', $tickets->user_id)->first();

                $fromaddress = $user_cred->email;
                $fromname = $user_cred->user_name;
                $phone = '';
                $phonecode = '';
                $mobile_number = '';

                $helptopic = $tickets->help_topic_id;
                $sla = $tickets->sla;
                $priority = $tickets->priority_id;
                $source = $tickets->source;
                $collaborator = '';
                $dept = $tickets->dept_id;
                $assign = $tickets->assigned_to;
                $form_data = null;
                $team_assign = null;
                $ticket_status = null;
                $auto_response = 0;

                $this->TicketWorkflowController->workflow($fromaddress, $fromname, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $collaborator, $dept, $assign, $team_assign, $ticket_status, $form_data, $auto_response);

                return \Redirect::back()->with('success1', Lang::get('lang.successfully_replied'));
            } else {
                return \Redirect::back()->with('fails1', Lang::get('lang.please_fill_some_data'));
            }
        } catch (Exception $e) {
            return \Redirect::back()->with('fails1', $e->getMessage());
        }
    }

    public function getCustomForm(Request $request)
    {
        $html = '';
        $helptopic_id = $request->input('helptopic');
        $helptopics = new Help_topic();
        $helptopic = $helptopics->find($helptopic_id);
        if (!$helptopic) {
            throw new Exception('We can not find your request');
        }
        $custom_form = $helptopic->custom_form;
        if ($custom_form) {
            $fields = new Fields();
            $forms = new \App\Model\helpdesk\Form\Forms();
            $form_controller = new \App\Http\Controllers\Admin\helpdesk\FormController($fields, $forms);
            $html = $form_controller->renderForm($custom_form);
        }

        return $html;
    }
}
