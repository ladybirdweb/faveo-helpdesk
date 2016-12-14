<?php

namespace App\Http\ViewComposers;

use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;
use Auth;
use Illuminate\View\View;

class AgentLayout
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $company;
    protected $users;
    protected $tickets;
    protected $department;

    /**
     * Create a new profile composer.
     *
     * @param
     *
     * @return void
     */
    public function __construct(Company $company, User $users, Tickets $tickets, Department $department)
    {
        $this->company = $company;
        $this->auth = Auth::user();
        $this->users = $users;
        $this->tickets = $tickets;
        $this->department = $department;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $notifications = \App\Http\Controllers\Common\NotificationController::getNotifications();
        $view->with([
            'company'         => $this->company,
            'notifications'   => $notifications,
            'myticket'        => $this->myTicket(),
            'unassigned'      => $this->unassigned(),
            'followup_ticket' => $this->followupTicket(),
            'deleted'         => $this->deleted(),
            'tickets'         => $this->inbox(),
            'department'      => $this->departments(),
            'overdues'        => $this->overdues(),
            'due_today'       => $this->getDueToday(),
        ]);
    }

    public function users()
    {
        return $this->users->select('id', 'profile_pic');
    }

    public function tickets()
    {
        return $this->tickets->select('id', 'ticket_number');
    }

    public function departments()
    {
        $array = [];
        $tickets = $this->tickets;
        if (\Auth::user()->role == 'agent') {
            $tickets = $tickets->where('tickets.dept_id', '=', \Auth::user()->primary_dpt);
        }
        $tickets = $tickets
                ->leftJoin('department as dep', 'tickets.dept_id', '=', 'dep.id')
                ->leftJoin('ticket_status', 'tickets.status', '=', 'ticket_status.id')
                ->select('dep.name as name', 'ticket_status.name as status', \DB::raw('COUNT(ticket_status.name) as count'))
                ->groupBy('dep.name', 'ticket_status.name')
                ->get();
        $grouped = $tickets->groupBy('name');
        $status = [];
        foreach ($grouped as $key => $group) {
            $status[$key] = $group->keyBy('status');
        }

        return collect($status);
    }

    public function myTicket()
    {
        $ticket = $this->tickets();
        if ($this->auth->role == 'admin') {
            return $ticket->where('assigned_to', $this->auth->id)
                    ->where('status', '1');
        } elseif ($this->auth->role == 'agent') {
            return $ticket->where('assigned_to', $this->auth->id)
                    ->where('status', '1');
        }
    }

    public function unassigned()
    {
        $ticket = $this->tickets();
        if ($this->auth->role == 'admin') {
            return $ticket->where('assigned_to', '=', null)
                    ->where('status', '=', '1')
                    ->select('id');
        } elseif ($this->auth->role == 'agent') {
            return $ticket->where('assigned_to', '=', null)
                    ->where('status', '=', '1')
                    ->where('dept_id', '=', $this->auth->primary_dpt)
                    ->select('id');
        }
    }

    public function followupTicket()
    {
        $ticket = $this->tickets();
        if ($this->auth->role == 'admin') {
            return $ticket->where('status', '1')->where('follow_up', '1')->select('id');
        } elseif ($this->auth->role == 'agent') {
            return $ticket->where('status', '1')->where('follow_up', '1')->select('id');
        }
    }

    public function deleted()
    {
        $ticket = $this->tickets();
        if ($this->auth->role == 'admin') {
            return $ticket->where('status', '5')->select('id');
        } elseif ($this->auth->role == 'agent') {
            return $ticket->where('status', '5')->where('dept_id', '=', $this->auth->primary_dpt)
                    ->select('id');
        }
    }

    public function inbox()
    {
        $ticket = $this->tickets();
        if ($this->auth->role == 'admin') {
            return $ticket->whereIn('status', [1, 7])->select('id');
        } elseif ($this->auth->role == 'agent') {
            return $ticket->whereIn('status', [1, 7])
                    ->where('dept_id', '=', $this->auth->primary_dpt)
                    ->orWhere('assigned_to', '=', Auth::user()->id)
                    ->select('id');
        }
    }

    public function overdues()
    {
        $ticket = $this->tickets();
        if ($this->auth->role == 'admin') {
            return $ticket->where('status', '=', 1)
                            ->where('isanswered', '=', 0)
                            ->whereNotNull('tickets.duedate')
                            ->where('tickets.duedate', '!=', '00-00-00 00:00:00')
                            ->where('tickets.duedate', '<', \Carbon\Carbon::now())
                            ->select('tickets.id');
        } elseif ($this->auth->role == 'agent') {
            return $ticket->where('status', '=', 1)
                            ->where('isanswered', '=', 0)
                            ->whereNotNull('tickets.duedate')
                            ->where('dept_id', '=', $this->auth->primary_dpt)
                            ->where('tickets.duedate', '!=', '00-00-00 00:00:00')
                            ->where('tickets.duedate', '<', \Carbon\Carbon::now())
                            ->select('tickets.id');
        }
    }

    public function getDueToday()
    {
        $ticket = $this->tickets();
        if ($this->auth->role == 'admin') {
            return $ticket->where('status', '=', 1)
                            ->where('status', '=', 1)
                            ->where('isanswered', '=', 0)
                            ->whereNotNull('duedate')
                            ->whereRaw('date(duedate) = ?', [date('Y-m-d')]);
        } elseif ($this->auth->role == 'agent') {
            return $ticket->where('status', '=', 1)
                            ->where('status', '=', 1)
                            ->where('isanswered', '=', 0)
                            ->whereNotNull('duedate')
                            ->where('dept_id', '=', $this->auth->primary_dpt)
                            ->whereRaw('date(duedate) = ?', [date('Y-m-d')]);
        }
    }
}
