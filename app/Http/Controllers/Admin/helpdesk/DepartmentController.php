<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controller
use App\Http\Controllers\Controller;
// request
use App\Http\Requests\helpdesk\DepartmentRequest;
use App\Http\Requests\helpdesk\DepartmentUpdate;
// model
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Group_assign_department;
use App\Model\helpdesk\Agent\Groups;
use App\Model\helpdesk\Agent\Teams;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Email\Template;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;
// classes
use DB;
use Exception;

/**
 * DepartmentController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * Get index page.
     *
     * @param type Department $department
     *
     * @return type Response
     */
    public function index(Department $department)
    {
        try {
            $departments = $department->get();

            return view('themes.default1.admin.helpdesk.agent.departments.index', compact('departments'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param type User                    $user
     * @param type Group_assign_department $group_assign_department
     * @param type Department              $department
     * @param type Sla_plan                $sla
     * @param type Template                $template
     * @param type Emails                  $email
     * @param type Groups                  $group
     *
     * @return type Response
     */
    public function create(User $user, Group_assign_department $group_assign_department, Department $department, Sla_plan $sla, Template $template, Emails $email, Groups $group)
    {
        try {
            $slas = $sla->get();
            $user = $user->where('role', 'agent')->get();
            $emails = $email->get();
            $templates = $template->get();
            $department = $department->get();
            $groups = $group->lists('id', 'name');

            return view('themes.default1.admin.helpdesk.agent.departments.create', compact('department', 'templates', 'slas', 'user', 'emails', 'groups'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Department        $department
     * @param type DepartmentRequest $request
     *
     * @return type Response
     */
    public function store(Department $department, DepartmentRequest $request)
    {
        try {
            $department->fill($request->except('group_id', 'manager'))->save();
            $requests = $request->input('group_id');
            $id = $department->id;
            if ($request->manager) {
                $department->manager = $request->input('manager');
            } else {
                $department->manager = null;
            }
            // foreach ($requests as $req) {
            // DB::insert('insert into group_assign_department(group_id, department_id) values (?,?)', [$req, $id]);
            // }
            /* Succes And Failure condition */
            /*  Check Whether the function Success or Fail */
            if ($department->save() == true) {
                return redirect('departments')->with('success', 'Department Created sucessfully');
            } else {
                return redirect('departments')->with('fails', 'Department can not Create');
            }
        } catch (Exception $e) {
            return redirect('departments')->with('fails', 'Department can not Create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type int                     $id
     * @param type User                    $user
     * @param type Group_assign_department $group_assign_department
     * @param type Template                $template
     * @param type Teams                   $team
     * @param type Department              $department
     * @param type Sla_plan                $sla
     * @param type Emails                  $email
     * @param type Groups                  $group
     *
     * @return type Response
     */
    public function edit($id, User $user, Group_assign_department $group_assign_department, Template $template, Teams $team, Department $department, Sla_plan $sla, Emails $email, Groups $group)
    {
        try {
            $slas = $sla->get();
            $user = $user->where('role', 'agent')->get();
            $emails = $email->get();
            $templates = $template->get();
            $departments = $department->whereId($id)->first();
            $groups = $group->lists('id', 'name');
            $assign = $group_assign_department->where('department_id', $id)->lists('group_id');

            return view('themes.default1.admin.helpdesk.agent.departments.edit', compact('assign', 'team', 'templates', 'departments', 'slas', 'user', 'emails', 'groups'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int                     $id
     * @param type Group_assign_department $group_assign_department
     * @param type Department              $department
     * @param type DepartmentUpdate        $request
     *
     * @return type Response
     */
    public function update($id, Group_assign_department $group_assign_department, Department $department, DepartmentUpdate $request)
    {
        // dd($id);
        try {
            $table = $group_assign_department->where('department_id', $id);
            $table->delete();
            $requests = $request->input('group_id');
            // foreach ($requests as $req) {
            // DB::insert('insert into group_assign_department (group_id, department_id) values (?,?)', [$req, $id]);
            // }
            $departments = $department->whereId($id)->first();

            if ($request->manager) {
                $departments->manager = $request->input('manager');
            } else {
                $departments->manager = null;
            }
            $departments->save();

            if ($departments->fill($request->except('group_access', 'manager'))->save()) {
                return redirect('departments')->with('success', 'Department Updated sucessfully');
            } else {
                return redirect('departments')->with('fails', 'Department not Updated');
            }
        } catch (Exception $e) {
            return redirect('departments')->with('fails', 'Department not Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int                     $id
     * @param type Department              $department
     * @param type Group_assign_department $group_assign_department
     *
     * @return type Response
     */
    public function destroy($id, Department $department, Group_assign_department $group_assign_department, System $system, Tickets $tickets)
    {
        // try {
        $system = $system->where('id', '=', '1')->first();
        if ($system->department == $id) {
            return redirect('departments')->with('fails', 'You cannot delete default department');
        } else {
            $tickets = DB::table('tickets')->where('dept_id', '=', $id)->update(['dept_id' => $system->department]);
            if ($tickets > 0) {
                if ($tickets > 1) {
                    $text_tickets = 'Tickets';
                } else {
                    $text_tickets = 'Ticket';
                }
                $ticket = '<li>'.$tickets.' '.$text_tickets.' have been moved to default department</li>';
            } else {
                $ticket = '';
            }
            $users = DB::table('users')->where('primary_dpt', '=', $id)->update(['primary_dpt' => $system->department]);
            if ($users > 0) {
                if ($users > 1) {
                    $text_user = 'Users';
                } else {
                    $text_user = 'User';
                }
                $user = '<li>'.$users.' '.$text_user.' have been moved to default department</li>';
            } else {
                $user = '';
            }
            $emails = DB::table('emails')->where('department', '=', $id)->update(['department' => $system->department]);
            if ($emails > 0) {
                if ($emails > 1) {
                    $text_emails = 'Emails';
                } else {
                    $text_emails = 'Email';
                }
                $email = '<li>'.$emails.' System '.$text_emails.' have been moved to default department</li>';
            } else {
                $email = '';
            }
            $helptopic = DB::table('help_topic')->where('department', '=', $id)->update(['department' => null], ['status' => '1']);
            if ($helptopic > 0) {
                $helptopic = '<li>The associated helptopic has been deactivated</li>';
            } else {
                $helptopic = '';
            }
            $message = $ticket.$user.$email.$helptopic;
            /* Becouse of foreign key we delete group_assign_department first */
            $group_assign_department = $group_assign_department->where('department_id', $id);
            $group_assign_department->delete();
            $departments = $department->whereId($id)->first();
            /* Check the function is Success or Fail */
            if ($departments->delete() == true) {
                return redirect('departments')->with('success', 'Department Deleted sucessfully'.$message);
            } else {
                return redirect('departments')->with('fails', 'Department can not Delete');
            }
        }
    }
}
