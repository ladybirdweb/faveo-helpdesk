<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\GroupRequest;
use App\Http\Requests\helpdesk\GroupUpdateRequest;
use App\Model\helpdesk\Agent\Department;
// models
use App\Model\helpdesk\Agent\Group_assign_department;
use App\Model\helpdesk\Agent\Groups;
use App\User;
use Exception;
// classes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * GroupController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @param type Groups                  $group
     * @param type Department              $department
     * @param type Group_assign_department $group_assign_department
     *
     * @return type Response
     */
    public function index(Groups $group, Department $department, Group_assign_department $group_assign_department)
    {
        try {
            $groups = $group->get();
            $departments = $department->lists('id');

            return view('themes.default1.admin.helpdesk.agent.groups.index', compact('departments', 'group_assign_department', 'groups'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return type Response
     */
    public function create()
    {
        try {
            return view('themes.default1.admin.helpdesk.agent.groups.create');
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Groups       $group
     * @param type GroupRequest $request
     *
     * @return type Response
     */
    public function store(Groups $group, GroupRequest $request)
    {
        try {
            /* Check Whether function success or not */
            $group->fill($request->input())->save();

            return redirect('groups')->with('success', 'Group Created Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('groups')->with('fails', 'Groups can not Create'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type int    $id
     * @param type Groups $group
     *
     * @return type Response
     */
    public function edit($id, Groups $group)
    {
        try {
            $groups = $group->whereId($id)->first();

            return view('themes.default1.admin.helpdesk.agent.groups.edit', compact('groups'));
        } catch (Exception $e) {
            return redirect('groups')->with('fails', 'Groups can not Create'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int     $id
     * @param type Groups  $group
     * @param type Request $request
     *
     * @return type Response
     */
    public function update($id, Groups $group, GroupUpdateRequest $request)
    {
        $var = $group->whereId($id)->first();
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
        try {
            $var->save();
            /* redirect to Index page with Success Message */
            return redirect('groups')->with('success', 'Group Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('groups')->with('fails', 'Groups can not Create'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int                     $id
     * @param type Groups                  $group
     * @param type Group_assign_department $group_assign_department
     *
     * @return type Response
     */
    public function destroy($id, Groups $group, Group_assign_department $group_assign_department)
    {
        $users = User::where('assign_group', '=', $id)->first();
        if ($users) {
            $user = '<li>There are agents assigned to this group. Please unassign them from this group to delete</li>';

            return redirect('groups')->with('fails', 'Group cannot Delete '.$user);
        }
        $group_assign_department->where('group_id', $id)->delete();
        $groups = $group->whereId($id)->first();
        /* Check whether function success or not */
        try {
            $groups->delete();
            /* redirect to Index page with Success Message */
            return redirect('groups')->with('success', 'Group Deleted Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('groups')->with('fails', 'Groups cannot Create'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }
}
