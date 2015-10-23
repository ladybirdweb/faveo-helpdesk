<?php namespace App\Http\Controllers\Admin\helpdesk;
// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\SettingsController;
// requests
use App\Http\Requests\helpdesk\TemplateRequest;
use App\Http\Requests\helpdesk\TemplateUdate;
// models
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Email\Template;
use App\Model\helpdesk\Utility\Languages;
// classes
use Illuminate\Http\Request;
use Mail;

/**
 * TemplateController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class TemplateController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */
	public function __construct() {
		SettingsController::smtp();
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 * @param type Template $template
	 * @return type Response
	 */
	public function index(Template $template) {
		try {
			$templates = $template->get();
			return view('themes.default1.admin.helpdesk.emails.template.index', compact('templates'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * @param type Languages $language
	 * @param type Template $template
	 * @return type Response
	 */
	public function create(Languages $language, Template $template) {
		try {
			$templates = $template->get();
			$languages = $language->get();
			return view('themes.default1.admin.helpdesk.emails.template.create', compact('languages', 'templates'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type Template $template
	 * @param type TemplateRequest $request
	 * @return type Response
	 */
	public function store(Template $template, TemplateRequest $request) {
		try {
			/* Check whether function success or not */
			if ($template->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('template')->with('success', 'Teams  Created Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('template')->with('fails', 'Teams  can not Create');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('template')->with('fails', 'Teams  can not Create');
		}
	}

	/**
	 * Display the specified resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param type $id
	 * @param type Template $template
	 * @param type Languages $language
	 * @return type Response
	 */
	public function edit($id, Template $template, Languages $language) {
		try {
			$templates = $template->whereId($id)->first();
			$languages = $language->get();
			return view('themes.default1.admin.helpdesk.emails.template.edit', compact('templates', 'languages'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * @param type int $id
	 * @param type Template $template
	 * @param type TemplateUdate $request
	 * @return type Response
	 */
	public function update($id, Template $template, TemplateUdate $request) {
		try {
			//TODO validation
			$templates = $template->whereId($id)->first();
			/* Check whether function success or not */
			if ($templates->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('template')->with('success', 'Teams  Updated Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('template')->with('fails', 'Teams can not Update');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('template')->with('fails', 'Teams can not Update');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @param type Template $template
	 * @return type Response
	 */
	public function destroy($id, Template $template) {
		try {
			$templates = $template->whereId($id)->first();
			/* Check whether function success or not */
			if ($templates->delete() == true) {
				/* redirect to Index page with Success Message */
				return redirect('template')->with('success', 'Teams  Deleted Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('template')->with('fails', 'Teams  can not Delete');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('template')->with('fails', 'Teams  can not Delete');
		}
	}

	/**
	 * Form for Email connection checking.
	 * @param type Emails $email
	 * @return type Response
	 */
	public function formDiagno(Emails $email) {
		try {
			$emails = $email->get();
			return view('themes.default1.admin.helpdesk.emails.template.formDiagno', compact('emails'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * function to send  emails
	 * @param type Request $request
	 * @return type
	 */
	public function postDiagno(Request $request) {
		$email = $request->input('to');
		if($email == null)
		{
			return redirect('getdiagno')->with('fails', 'Please provide E-mail address !');
		}
		$mail = Mail::send('themes.default1.admin.helpdesk.emails.template.connection', array('link' => url('getmail'), 'username' => $email), function ($message) use ($email) {
			$message->to($email)->subject('Checking the connection');
		});
		return redirect('getdiagno')->with('success', 'Please check your mail. An E-mail has been sent to your E-mail address');
	}
	
}
