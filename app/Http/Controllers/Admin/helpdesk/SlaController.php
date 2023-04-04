<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\SlaRequest;
use App\Http\Requests\helpdesk\SlaUpdate;
// models
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Settings\Ticket;
//classes
use DB;
use Exception;
use Lang;

/**
 * SlaController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class SlaController extends Controller
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
     * @param type Sla_plan $sla
     *
     * @return type Response
     */
    public function index(Sla_plan $sla)
    {
        try {
            /* Declare a Variable $slas to store all Values From Sla_plan Table */
            $slas = $sla->get();
            /* Listing the values From Sla_plan Table */
            return view('themes.default1.admin.helpdesk.manage.sla.index', compact('slas'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
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
            /* Direct to Create Page */
            return view('themes.default1.admin.helpdesk.manage.sla.create');
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Sla_plan   $sla
     * @param type SlaRequest $request
     *
     * @return type Response
     */
    public function store(Sla_plan $sla, SlaRequest $request)
    {
        try {
            /* Fill the request values to Sla_plan Table  */
            /* Check whether function success or not */
            $sla->fill($request->input())->save();
            /* redirect to Index page with Success Message */
            return redirect('sla')->with('success', Lang::get('lang.sla_plan_created_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('sla')->with('fails', Lang::get('lang.sla_plan_can_not_create').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type int      $id
     * @param type Sla_plan $sla
     *
     * @return type Response
     */
    public function edit($id)
    {
        try {
            /* Direct to edit page along values of perticular field using Id */
            $slas = Sla_plan::whereId($id)->first();
            $slas->get();
            $sla = \DB::table('settings_ticket')->select('sla')->where('id', '=', 1)->first();

            return view('themes.default1.admin.helpdesk.manage.sla.edit', compact('slas', 'sla'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int       $id
     * @param type Sla_plan  $sla
     * @param type SlaUpdate $request
     *
     * @return type Response
     */
    public function update($id, SlaUpdate $request)
    {
        try {
            /* Fill values to selected field using Id except Check box */
            $slas = Sla_plan::whereId($id)->first();
            $slas->fill($request->except('transient', 'ticket_overdue'))->save();
            /* Update transient checkox field */
            $slas->transient = $request->input('transient');
            /* Update ticket_overdue checkox field */
            $slas->ticket_overdue = $request->input('ticket_overdue');
            /* Check whether function success or not */
            $slas->save();
            /* redirect to Index page with Success Message */
            if ($request->input('sys_sla') == 'on') {
                \DB::table('settings_ticket')
                     ->where('id', '=', 1)
                     ->update(['sla' => $id]);
            }

            return redirect('sla')->with('success', Lang::get('lang.sla_plan_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('sla')->with('fails', Lang::get('lang.sla_plan_can_not_update').'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int      $id
     * @param type Sla_plan $sla
     *
     * @return type Response
     */
    public function destroy($id)
    {
        $default_sla = Ticket::where('id', '=', '1')->first();
        if ($default_sla->sla == $id) {
            return redirect('departments')->with('fails', Lang::get('lang.you_cannot_delete_default_department'));
        } else {
            $tickets = DB::table('tickets')->where('sla', '=', $id)->update(['sla' => $default_sla->sla]);
            if ($tickets > 0) {
                if ($tickets > 1) {
                    $text_tickets = 'Tickets';
                } else {
                    $text_tickets = 'Ticket';
                }
                $ticket = '<li>'.$tickets.' '.$text_tickets.Lang::get('lang.have_been_moved_to_default_sla').'</li>';
            } else {
                $ticket = '';
            }
            $dept = DB::table('department')->where('sla', '=', $id)->update(['sla' => $default_sla->sla]);
            if ($dept > 0) {
                if ($dept > 1) {
                    $text_dept = 'Emails';
                } else {
                    $text_dept = 'Email';
                }
                $dept = '<li>'.Lang::get('lang.associated_department_have_been_moved_to_default_sla').'</li>';
            } else {
                $dept = '';
            }
            $topic = DB::table('help_topic')->where('sla_plan', '=', $id)->update(['sla_plan' => $default_sla->sla]);
            if ($topic > 0) {
                if ($topic > 1) {
                    $text_topic = 'Emails';
                } else {
                    $text_topic = 'Email';
                }
                $topic = '<li>'.Lang::get('lang.associated_help_topic_have_been_moved_to_default_sla').'</li>';
            } else {
                $topic = '';
            }
            $message = $ticket.$dept.$topic;
            /* Delete a perticular field from the database by delete() using Id */
            $slas = Sla_plan::whereId($id)->first();
            /* Check whether function success or not */
            try {
                $slas->delete();
                /* redirect to Index page with Success Message */
                return redirect('sla')->with('success', Lang::get('lang.sla_plan_deleted_successfully').$message);
            } catch (Exception $e) {
                /* redirect to Index page with Fails Message */
                return redirect('sla')->with('fails', Lang::get('lang.sla_plan_can_not_delete').'<li>'.$e->getMessage().'</li>');
            }
        }
    }
}
