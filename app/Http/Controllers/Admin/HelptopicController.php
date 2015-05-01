<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;

/* my own Request to Validate The create form  */
use App\Http\Requests\HelptopicRequest;

/* Include HelptopicUpdate for update validation*/
use App\Http\Requests\HelptopicUpdate;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/*Using Department Model*/
use App\Model\Agent\Department;

/*Using Help_topic Model*/
use App\Model\Manage\Help_topic;

/*Using Agents Model*/
use App\Model\Agent\Agents;

/*Using Sla_plan Model*/
use App\Model\Manage\Sla_plan;

/*Using Forms Model*/
use App\Model\Form\Form_name;

/* Include Priority Model */
use App\Model\Utility\Priority;



class HelptopicController extends Controller {

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
	public function index(Help_topic $topic)
	{
		try
		{
			$topics = $topic->get();
			return view('themes.default1.admin.manage.helptopic.index',compact('topics'));
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
	public function create(Priority $priority,Department $department, Help_topic $topic, Form_name $form, Agents $agent, Sla_plan $sla)
	{
		try
		{
			$departments = $department->get();
			$topics = $topic->get();
			$forms = $form->get();
			$agents = $agent->get();
			$slas = $sla->get();
			$priority = $priority->get();

			return view('themes.default1.admin.manage.helptopic.create',compact('priority','departments','topics','forms','agents','slas'));
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
	public function store(Help_topic $topic, HelptopicRequest $request)
	{
		try
		{
			/* Check whether function success or not */

			if($topic->fill($request->input())->save()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('helptopic')->with('success','Helptopic Created Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('helptopic')->with('fails','Helptopic can not Create');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('helptopic')->with('fails','Helptopic can not Create');	
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
	public function edit($id,Priority $priority,Department $department, Help_topic $topic, Form_name $form, Agents $agent, Sla_plan $sla)
	{
		try
		{
			$departments = $department->get();
			$topics = $topic->whereId($id)->first();
			$forms = $form->get();
			$agents = $agent->get();
			$slas = $sla->get();
			$priority = $priority->get();

			return view('themes.default1.admin.manage.helptopic.edit',compact('priority','departments','topics','forms','agents','slas'));
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
	public function update($id, Help_topic $topic, HelptopicUpdate $request)
	{
		try
		{
			$topics = $topic->whereId($id)->first();
			
			/* Check whether function success or not */

			if($topics->fill($request->input())->save()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('helptopic')->with('success','Helptopic Updated Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('helptopic')->with('fails','Helptopic can not Updated');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('helptopic')->with('fails','Helptopic can not Create');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Help_topic $topic)
	{
		try
		{
			$topics = $topic->whereId($id)->first();

			/* Check whether function success or not */

			if($topics->delete()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('helptopic')->with('success','Helptopic Deleted Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('helptopic')->with('fails','Helptopic can not Delete');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('helptopic')->with('fails','Helptopic can not Create');
		}
	}

}
