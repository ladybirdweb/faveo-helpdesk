<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\GroupRequest;
use App\Model\Agent\Groups;

use App\Model\Agent\Group_assign_department;

use App\Model\Agent\Department;

class GroupController extends Controller {


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
	
	
	public function index(Groups $group, Department $department,Group_assign_department $group_assign_department)
	{
		try
		{
			$groups = $group->get();
			$departments = $department->lists('id');
			return view('themes.default1.admin.agent.groups.index',compact('departments','group_assign_department','groups'));
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
	public function create()
	{
		try
		{
			return view('themes.default1.admin.agent.groups.create');
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
	public function store(Groups $group,GroupRequest $request)
	{
		try
		{
			/* Check Whether function success or not */
		
			if($group->fill($request->input())->save()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('groups')->with('success','Groups Created Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('groups')->with('fails','Groups can not Create');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('groups')->with('fails','Groups can not Create');
		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Groups $group, Request $request)
	{
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Groups $group)
	{
		try
		{
			$groups = $group->whereId($id)->first();
			return view('themes.default1.admin.agent.groups.edit',compact('groups'));
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
	public function update($id, Groups $group, Request $request )
	{
		try
		{
			$var = $group->whereId($id)->first() ;
			//Updating Name
			// $name = $request->Input('name');
			// $var->name = $name;
			//Updating Status	
			$status = $request->Input('group_status');
			$var->group_status = $status;
			//Updating can_create_ticket field
			$createTicket = $request->Input('can_create_ticket');
			$var->can_create_ticket = $createTicket;
			//Updating can_edit_ticket field
			$editTicket = $request->Input('can_edit_ticket');
			$var->can_edit_ticket = $editTicket;
			//Updating can_post_ticket field
			$postTicket = $request->Input('can_post_ticket');
			$var->can_post_ticket = $postTicket;
			//Updating can_close_ticket field
			$closeTicket = $request->Input('can_close_ticket');
			$var->can_close_ticket = $closeTicket;
			//Updating can_assign_ticket field
			$assignTicket = $request->Input('can_assign_ticket');
			$var->can_assign_ticket = $assignTicket;
			//Updating can_trasfer_ticket field
			$trasferTicket = $request->Input('can_trasfer_ticket');
			$var->can_trasfer_ticket = $trasferTicket;
			//Updating can_delete_ticket field
			$deleteTicket = $request->Input('can_delete_ticket');
			$var->can_delete_ticket = $deleteTicket;
			//Updating can_ban_email field
			$banEmail = $request->Input('can_ban_email');
			$var->can_ban_email = $banEmail;
			//Updating can_manage_canned field
			$manageCanned = $request->Input('can_manage_canned');
			$var->can_manage_canned = $manageCanned;
			//Updating can_manage_faq field
			$manageFaq = $request->Input('can_manage_faq');
			$var->can_manage_faq = $manageFaq;
			//Updating can_view_agent_stats field
			$viewAgentStats = $request->Input('can_view_agent_stats');
			$var->can_view_agent_stats = $viewAgentStats;
			//Updating department_access field
			$departmentAccess = $request->Input('department_access');
			$var->department_access = $departmentAccess;
			//Updating admin_notes field
			$adminNotes = $request->Input('admin_notes');
			$var->admin_notes = $adminNotes;

			/* Check whether function success or not */

			if($var->save()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('groups')->with('success','Group Updated Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('groups')->with('fails','Group can not Update');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('groups')->with('fails','Groups can not Create');
		}
		
		
	}
	// public function delete($id, Groups $group)
	// {
	// 	return view('')
	// }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Groups $group, Group_assign_department $group_assign_department)
	{
		try
		{
			$group_assign_department->where('group_id',$id)->delete();

			$groups = $group->whereId($id)->first();

			/* Check whether function success or not */

			if($groups->delete()==true)
			{
				/* redirect to Index page with Success Message */
				return redirect('groups')->with('success','Group Deleted Successfully');
			}
			else
			{
				/* redirect to Index page with Fails Message */
				return redirect('groups')->with('fails','Group can not Delete');	
			}
		}
		catch(Exception $e)
		{
			/* redirect to Index page with Fails Message */
			return redirect('groups')->with('fails','Groups can not Create');
		}

	}

	
}
