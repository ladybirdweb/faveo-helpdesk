<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// request
use App\Http\Requests\helpdesk\EmailsEditRequest;
use App\Http\Requests\helpdesk\EmailsRequest;
// model
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Settings\Email;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Utility\MailboxProtocol;
// classes
use Crypt;
use Exception;

/**
 * EmailsController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class EmailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @param type Emails $emails
     *
     * @return type Response
     */
    public function index(Emails $emails)
    {
        try {
            $emails = $emails->get();

            return view('themes.default1.admin.helpdesk.emails.emails.index', compact('emails'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param type Department      $department
     * @param type Help_topic      $help
     * @param type Priority        $priority
     * @param type MailboxProtocol $mailbox_protocol
     *
     * @return type Response
     */
    public function create(Department $department, Help_topic $help, Ticket_Priority $priority, MailboxProtocol $mailbox_protocol)
    {
        try {
            $departments = $department->get();
            $helps = $help->get();
            $priority = $priority->get();
            $mailbox_protocols = $mailbox_protocol->get();

            return view('themes.default1.admin.helpdesk.emails.emails.create', compact('mailbox_protocols', 'priority', 'departments', 'helps'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Emails        $email
     * @param type EmailsRequest $request
     *
     * @return type Response
     */
    public function store(Emails $email, EmailsRequest $request)
    {
        try {
            $password = $request->input('password');
            $encrypted = Crypt::encrypt($password);
            $department = $request->input('department');
            $priority = $request->input('priority');
            $help_topic = $request->input('help_topic');

            if ($email->fill($request->except('password', 'department', 'priority', 'help_topic'))->save() == true) {
                if ($request->input('department')) {
                    $email->department = $request->input('department');
                } else {
                    $email->department = null;
                }
                if ($request->input('priority')) {
                    $email->priority = $request->input('priority');
                } else {
                    $email->priority = null;
                }
                if ($request->input('help_topic')) {
                    $email->help_topic = $request->input('help_topic');
                } else {
                    $email->help_topic = null;
                }
                $email->password = $encrypted;
                $email->save();

                $email_settings = Email::where('id', '=', '1')->first();
                $email_settings->sys_email = $email->id;
                $email_settings->save();

                return redirect('emails')->with('success', 'Email Created sucessfully');
            } else {
                return redirect('emails')->with('fails', 'Email can not Create');
            }
        } catch (Exception $e) {
            return redirect('emails')->with('fails', 'Email can not Create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type int             $id
     * @param type Department      $department
     * @param type Help_topic      $help
     * @param type Emails          $email
     * @param type Priority        $priority
     * @param type MailboxProtocol $mailbox_protocol
     *
     * @return type Response
     */
    public function edit($id, Department $department, Help_topic $help, Emails $email, Ticket_Priority $priority, MailboxProtocol $mailbox_protocol)
    {
        try {
            $emails = $email->whereId($id)->first();
            $departments = $department->get();
            $helps = $help->get();
            $priority = $priority->get();
            $mailbox_protocols = $mailbox_protocol->get();

            return view('themes.default1.admin.helpdesk.emails.emails.edit', compact('mailbox_protocols', 'priority', 'departments', 'helps', 'emails'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type                   $id
     * @param type Emails            $email
     * @param type EmailsEditRequest $request
     *
     * @return type Response
     */
    public function update($id, Emails $email, EmailsEditRequest $request)
    {
        $password = $request->input('password');
        $encrypted = Crypt::encrypt($password);
        //echo $encrypted;
        //$value = Crypt::decrypt($encrypted);
        //echo $value;
        try {
            $emails = $email->whereId($id)->first();
            // $emails->password = $encrypted;
            $emails->fill($request->except('password', 'department', 'priority', 'help_topic'))->save();
            if ($request->input('department')) {
                $emails->department = $request->input('department');
            } else {
                $emails->department = null;
            }
            if ($request->input('priority')) {
                $emails->priority = $request->input('priority');
            } else {
                $emails->priority = null;
            }
            if ($request->input('help_topic')) {
                $emails->help_topic = $request->input('help_topic');
            } else {
                $emails->help_topic = null;
            }
            $emails->password = $encrypted;
            $emails->save();

            return redirect('emails')->with('success', 'Email Updated sucessfully');
        } catch (Exception $e) {
            return redirect('emails')->with('fails', 'Email not updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int    $id
     * @param type Emails $email
     *
     * @return type Response
     */
    public function destroy($id, Emails $email)
    {
        $default_system_email = Email::where('id', '=', '1')->first();
        if ($default_system_email->sys_email) {
            if ($id == $default_system_email->sys_email) {
                return redirect('emails')->with('fails', 'You cannot delete system default Email');
            }
        }
        try {
            $emails = $email->whereId($id)->first();
            if ($emails->delete() == true) {
                return redirect('emails')->with('success', 'Email Deleted sucessfully');
            } else {
                return redirect('emails')->with('fails', 'Email can not  Delete ');
            }
        } catch (Exception $e) {
            return redirect('emails')->with('fails', 'Email can not  Delete ');
        }
    }
}
