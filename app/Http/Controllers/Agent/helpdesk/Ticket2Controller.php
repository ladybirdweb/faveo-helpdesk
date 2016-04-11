<?php

namespace App\Http\Controllers\Agent\helpdesk;

// controllers
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Controller;
// requests
// models
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Collaborator;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;
use Auth;
use DB;
// classes
use Illuminate\support\Collection;
use Input;
use UTC;
use Tickable;

/**
 * TicketController2.
 *
 * @author Ladybird <info@ladybirdweb.com>
 */
class Ticket2Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type response
     */
    public function __construct()
    {
        SettingsController::smtp();
        $this->middleware('auth');
    }

    /**
     * Show the Inbox ticket list page.
     *
     * @return type response
     */
    public function deptopen($id)
    {
        $dept = Department::where('name', '=', $id)->first();
        if (Auth::user()->role == 'agent') {
            if (Auth::user()->dept_id == $dept->id) {
                return view('themes.default1.agent.helpdesk.dept-ticket.open', compact('id'));
            } else {
                return redirect()->back()->with('fails', 'Unauthorised!');
            }
        } else {
            return view('themes.default1.agent.helpdesk.dept-ticket.open', compact('id'));
        }
    }

    public function getOpenTickets($id)
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->where('dept_id', '=', $id)->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->get();
        }

        return Tickable::makeTable($tickets);
    }

    /**
     * Show the Inbox ticket list page.
     *
     * @return type response
     */
    public function deptclose($id)
    {
        $dept = Department::where('name', '=', $id)->first();
        if (Auth::user()->role == 'agent') {
            if (Auth::user()->dept_id == $dept->id) {
                return view('themes.default1.agent.helpdesk.dept-ticket.closed', compact('id'));
            } else {
                return redirect()->back()->with('fails', 'Unauthorised!');
            }
        } else {
            return view('themes.default1.agent.helpdesk.dept-ticket.closed', compact('id'));
        }
    }

    public function getCloseTickets($id)
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', '2')->where('dept_id', '=', $id)->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '=', '2')->where('dept_id', '=', $dept->id)->get();
        }

        return Tickable::makeTable($tickets);
    }

    /**
     * Show the Inbox ticket list page.
     *
     * @return type response
     */
    public function deptinprogress($id)
    {
        $dept = Department::where('name', '=', $id)->first();
        if (Auth::user()->role == 'agent') {
            if (Auth::user()->dept_id == $dept->id) {
                return view('themes.default1.agent.helpdesk.dept-ticket.inprogress', compact('id'));
            } else {
                return redirect()->back()->with('fails', 'Unauthorised!');
            }
        } else {
            return view('themes.default1.agent.helpdesk.dept-ticket.inprogress', compact('id'));
        }
    }

    /**
     *Show the list of In process tickets.
     *
     *@param $id int
     */
    public function getInProcessTickets($id)
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::where('status', '=', '1')->where('assigned_to', '>', 0)->where('dept_id', '=', $id)->get();
        } else {
            $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::where('status', '=', '1')->where('assigned_to', '>', 0)->where('dept_id', '=', $dept->id)->get();
        }

        return Tickable::makeTable($tickets);
    }
}
