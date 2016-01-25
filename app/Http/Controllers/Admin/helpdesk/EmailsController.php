<?php namespace App\Http\Controllers\Admin\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// request
use App\Http\Requests\helpdesk\EmailsEditRequest;
use App\Http\Requests\helpdesk\EmailsRequest;
// model
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Utility\MailboxProtocol;
use App\Model\helpdesk\Ticket\Ticket_Priority;
// classes
use Crypt;
use Exception;

/**
 * EmailsController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class EmailsController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 * @param type Emails $emails
	 * @return type Response
	 */
	public function index(Emails $emails) {
		try {
			$emails = $emails->get();
			return view('themes.default1.admin.helpdesk.emails.emails.index', compact('emails'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * @param type Department $department
	 * @param type Help_topic $help
	 * @param type Priority $priority
	 * @param type MailboxProtocol $mailbox_protocol
	 * @return type Response
	 */
	public function create(Department $department, Help_topic $help, Ticket_Priority $priority, MailboxProtocol $mailbox_protocol) {
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
	 * @param type Emails $email
	 * @param type EmailsRequest $request
	 * @return type Response
	 */
	public function store(Emails $email, EmailsRequest $request) {
		try {
			$password = $request->input('password');
			$encrypted = Crypt::encrypt($password);
			$email->password = $encrypted;
			if ($email->fill($request->except('password'))->save() == true) {
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
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param type int $id
	 * @param type Department $department
	 * @param type Help_topic $help
	 * @param type Emails $email
	 * @param type Priority $priority
	 * @param type MailboxProtocol $mailbox_protocol
	 * @return type Response
	 */
	public function edit($id, Department $department, Help_topic $help, Emails $email, Ticket_Priority $priority, MailboxProtocol $mailbox_protocol) {
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
	 * @param type $id
	 * @param type Emails $email
	 * @param type EmailsEditRequest $request
	 * @return type Response
	 */
	public function update($id, Emails $email, EmailsEditRequest $request) {
		$password = $request->input('password');
		$encrypted = Crypt::encrypt($password);
		//echo $encrypted;
		//$value = Crypt::decrypt($encrypted);
		//echo $value;
		try {
			$emails = $email->whereId($id)->first();
			$emails->password = $encrypted;
			$emails->fill($request->except('password'))->save();
			return redirect('emails')->with('success', 'Email Updated sucessfully');
		} catch (Exception $e) {
			return redirect('emails')->with('fails', 'Email not updated');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @param type Emails $email
	 * @return type Response
	 */
	public function destroy($id, Emails $email) {
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
