<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\TemplateRequest;
use App\Http\Requests\DiagnoRequest;
use App\Http\Controllers\Controller;
/* include TemplateUpdate request for update validation  */
use App\Http\Requests\TemplateUdate;
use Illuminate\Http\Request;
use App\Model\Email\Template;
use App\Model\Utility\Languages;
use App\Model\Email\Emails;

use Mail;
class TemplateController extends Controller {

	/*  constructor for authentication  */

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Template $template)
	{
		try
		{
			$templates = $template->get();
			return view('themes.default1.admin.emails.template.index',compact('templates'));
		}
		catch(Exception $e)
		{
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Languages $language, Template $template )
	{
		try
		{
			$templates = $template->get();
			$languages = $language->get();
			return view('themes.default1.admin.emails.template.create',compact('languages','templates'));
		}
		catch(Exception $e)
		{
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Template $template, TemplateRequest $request)
	{
		try
		{	
			/* Check whether function success or not */

			if($template->fill($request->input())->save()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('template')->with('success','Teams  Created Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('template')->with('fails','Teams  can not Create');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('template')->with('fails','Teams  can not Create');
		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Template $template, Languages $language)
	{
		try
		{
			$templates = $template->whereId($id)->first();
			$languages = $language->get();
			return view('themes.default1.admin.emails.template.edit',compact('templates','languages'));
		}
		catch(Exception $e)
		{
			return view('404');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Template $template, TemplateUdate $request)
	{
		try
		{
			//TODO validation
			$templates = $template->whereId($id)->first();
			
			/* Check whether function success or not */

			if($templates->fill($request->input())->save()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('template')->with('success','Teams  Updated Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('template')->with('fails','Teams can not Update');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('template')->with('fails','Teams can not Update');
		}
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Template $template)
	{
		try
		{
			$templates = $template->whereId($id)->first();
			
			/* Check whether function success or not */

			if($templates->delete()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('template')->with('success','Teams  Deleted Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('template')->with('fails','Teams  can not Delete');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('template')->with('fails','Teams  can not Delete');
		}
		
	}

	/**
	 * Form for Email connection checking.
	 *
	 * @param  
	 * @return Response
	 */
	public function formDiagno(Emails $email)
	{
		try
		{
			$emails = $email->get();
			return view('themes.default1.admin.emails.template.formDiagno', compact('emails'));
		}
		catch(Exception $e)
		{
			return view('404');
		}
	}
	
		/*
			To Do function for Sending an Email
		*/
	
	public function postDiagno(Request $request)
	{
		$email = $request->input('to');
		$subject = $request->input('subject');

		$mail =  Mail::send('themes.default1.admin.emails.template.connection',array('link' => url('getmail'), 'username' => $email),  function($message) use($email) {
                        $message->to($email)->subject('Checking the connection');
                    });

		return redirect('getdiagno')->with('success','Activate Your Account ! Click on Link that send to your mail');

		
	}
}
