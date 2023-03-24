<?php

namespace App\Http\Controllers\Agent\helpdesk\Filter;

use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Controllers\Controller;
use App\Model\helpdesk\Filters\Filter;
use App\Model\helpdesk\Ticket\Tickets;
use Auth;
use DB;
use Illuminate\Http\Request;

class FilterControllerOld extends Controller
{
    protected $request;

    public function __construct(Request $req)
    {
        $this->middleware(['auth', 'role.agent']);
        $this->request = $req;
    }

    public function getFilter(Request $request)
    {
        $labels = $this->request->input('labels');
        $tags = $this->request->input('tags');
        if ($request->has('department')) {
            $table = $this->departmentTickets($request->input('department'), $request->input('status'));
        } else {
            $segment = $this->request->input('segment');
            $table = $this->segments($segment);
        }
        $tickets = [];
        $render = false;
        if (is_array($labels) && count($labels) > 0) {
            $table = $table
                     ->leftJoin('filters as label', function ($join) {
                         $join->on('tickets.id', '=', 'label.ticket_id')
                                ->where('label.key', '=', 'label');
                     })
                    ->whereIn('label.value', $labels);
        }
        if (is_array($tags) && count($tags) > 0) {
            $table = $table
                    ->leftJoin('filters as tag', function ($join) {
                        $join->on('tickets.id', '=', 'tag.ticket_id')
                                ->where('tag.key', '=', 'tag');
                    })
                    ->whereIn('tag.value', $tags);
        }
        if ((is_array($tags) && count($tags) > 0) || (is_array($labels) && count($labels) > 0)) {
            $render = true;
        }
        // return \Datatables::of($table)->make();
        return \Ttable::getTable($table);
    }

    public function filterByKey($key, $labels = [])
    {
        $filter = new Filter();
        $query = $filter->where('key', $key)
                ->where(function ($query) use ($labels) {
                    if (is_array($labels) && count($labels) > 0) {
                        for ($i = 0; $i < count($labels); $i++) {
                            $query->orWhere('value', 'LIKE', '%'.$labels[$i].'%');
                        }
                    }
                })
                ->pluck('ticket_id')
                ->toArray();

        return $query;
    }

    public function segments($segment)
    {
        if (strpos($segment, 'user') !== false) {
            return $this->formatUserTickets($segment);
        }
        $table = $this->table();
        switch ($segment) {
            case '/ticket/inbox':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id)->orWhere('assigned_to', '=', Auth::user()->id);
                }

                return $table
                    ->Join('ticket_status', function ($join) {
                        $join->on('ticket_status.id', '=', 'tickets.status')
                        ->whereIn('ticket_status.id', [1, 7]);
                    });
            case '/ticket/closed':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                    ->Join('ticket_status', function ($join) {
                        $join->on('ticket_status.id', '=', 'tickets.status')
                                ->whereIn('ticket_status.state', ['closed']);
                    });
            case '/ticket/myticket':
                return $table
                  ->leftJoin('ticket_status', function ($join) {
                      $join->on('ticket_status.id', '=', 'tickets.status');
                  })
                ->orWhere('tickets.assigned_to', '=', Auth::user()->id)
                ->where('tickets.status', '=', 1);
            case '/unassigned':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                     ->leftJoin('ticket_status', function ($join) {
                         $join->on('ticket_status.id', '=', 'tickets.status');
                     })
                    ->where('tickets.assigned_to', '=', null)
                    ->where('tickets.status', '=', 1);
            case '/ticket/overdue':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                  ->leftJoin('ticket_status', function ($join) {
                      $join->on('ticket_status.id', '=', 'tickets.status');
                  })
                  ->where('tickets.status', '=', 1)
                  ->where('tickets.isanswered', '=', 0)
                  ->whereNotNull('tickets.duedate')
                  ->where('tickets.duedate', '!=', '00-00-00 00:00:00')

                  // ->where('duedate','>',\Carbon\Carbon::now());
                  ->where('tickets.duedate', '<', \Carbon\Carbon::now());
            case '/ticket/approval/closed':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                    ->Join('ticket_status', function ($join) {
                        $join->on('ticket_status.id', '=', 'tickets.status')
                                ->where('tickets.status', '=', 7);
                    });

            case '/trash':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                    ->Join('ticket_status', function ($join) {
                        $join->on('ticket_status.id', '=', 'tickets.status')
                                ->where('tickets.status', '=', 5);
                    });

            case '/ticket/answered':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                    ->Join('ticket_status', function ($join) {
                        $join->on('ticket_status.id', '=', 'tickets.status')
                                ->where('tickets.status', '=', 1)
                                ->where('tickets.isanswered', '=', 1);
                    });
            case '/ticket/assigned':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                     ->leftJoin('ticket_status', function ($join) {
                         $join->on('ticket_status.id', '=', 'tickets.status');
                     })
                    ->where('tickets.assigned_to', '>', 0)
                    ->where('tickets.status', '=', 1);
            case '/ticket/open':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                     ->leftJoin('ticket_status', function ($join) {
                         $join->on('ticket_status.id', '=', 'tickets.status');
                     })
                    ->where('isanswered', '=', 0)
                    ->where('tickets.status', '=', 1);
            case '/duetoday':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                     ->leftJoin('ticket_status', function ($join) {
                         $join->on('ticket_status.id', '=', 'tickets.status');
                     })
                     ->where('tickets.status', '=', 1)

                     ->whereNotNull('tickets.duedate')
                     ->whereDate('tickets.duedate', '=', \Carbon\Carbon::now()->format('Y-m-d'));

            case '/ticket/followup':
                if (Auth::user()->role == 'agent') {
                    $id = Auth::user()->primary_dpt;
                    $table = $table->where('tickets.dept_id', '=', $id);
                }

                return $table
                    ->leftJoin('ticket_status', function ($join) {
                        $join->on('ticket_status.id', '=', 'tickets.status');
                    })
                    ->where('tickets.status', '=', 1)
                    // ->where('tickets.isanswered', '=', 0)
                    ->where('tickets.follow_up', '=', 1);
        }
    }

    public function table()
    {
        // if (Auth::user()->role == 'admin') {
        $ticket = new Tickets();
        $tickets = $ticket
                    ->leftJoin('ticket_thread', function ($join) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->whereNotNull('title')
                        ->where('ticket_thread.is_internal', '<>', 1);
                    })
                    ->leftJoin('ticket_thread as ticket_thread2', 'ticket_thread2.ticket_id', '=', 'tickets.id')
                    ->Join('ticket_source', 'ticket_source.id', '=', 'tickets.source')
                    ->leftJoin('ticket_priority', 'ticket_priority.priority_id', '=', 'tickets.priority_id')
                    ->leftJoin('users as u', 'u.id', '=', 'tickets.user_id')
                    ->leftJoin('users as u1', 'u1.id', '=', 'tickets.assigned_to')
                    ->leftJoin('ticket_attachment', 'ticket_attachment.thread_id', '=', 'ticket_thread.id')

                    ->leftJoin('ticket_collaborator', 'ticket_collaborator.ticket_id', '=', 'tickets.id')
                    ->select(
                        'tickets.id',
                        'ticket_thread.title',
                        'tickets.ticket_number',
                        'ticket_priority.priority',
                        'u.user_name as user_name',
                        'u1.user_name as assign_user_name',
                        \DB::raw('max(ticket_thread.updated_at) as updated_at'),
                        \DB::raw('min(ticket_thread.updated_at) as created_at'),
                        'u.first_name as first_name',
                        'u.last_name as last_name',
                        'u1.first_name as assign_first_name',
                        'u1.last_name as assign_last_name',
                        'ticket_priority.priority_color',
                        DB::raw('COUNT(DISTINCT ticket_thread2.id) as countthread'),
                        DB::raw('COUNT(ticket_attachment.thread_id) as countattachment'),
                        DB::raw('COUNT(ticket_collaborator.ticket_id) as countcollaborator'),
                        'tickets.status',
                        'tickets.user_id',
                        'tickets.priority_id',
                        'tickets.assigned_to',
                        'ticket_status.name as tickets_status',
                        'ticket_source.css_class as css',
                        DB::raw('substring_index(group_concat(ticket_thread.poster order by ticket_thread.id desc) , ",", 1) as last_replier'),
                        DB::raw('substring_index(group_concat(ticket_thread.title order by ticket_thread.id asc) , ",", 1) as ticket_title'),
                        'u.active as verified'
                    )
                    ->groupby('tickets.id');

        return $tickets;
    }

    public function filter($render, $ticket_id = [])
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Tickets::whereIn('status', [1, 7]);
        } else {
            $dept = DB::table('department')->where('id', '=', Auth::user()->primary_dpt)->first();
            $tickets = Tickets::whereIn('status', [1, 7])->where('dept_id', '=', $dept->id);
        }
        if ($render == true) {
            $tickets = $tickets->whereIn('id', $ticket_id);
        }

        return $tickets;
    }

    public function ticketController()
    {
        $PhpMailController = new \App\Http\Controllers\Common\PhpMailController();
        $NotificationController = new \App\Http\Controllers\Common\NotificationController();
        $ticket_controller = new TicketController($PhpMailController, $NotificationController);

        return $ticket_controller;
    }

    public function departmentTickets($dept, $status)
    {
        $table = $this->table();

        return $table->leftJoin('department as dep', 'tickets.dept_id', '=', 'dep.id')
                ->leftJoin('ticket_status', 'tickets.status', '=', 'ticket_status.id')
                ->where('dep.name', $dept)
                ->where('ticket_status.name', $status);
    }

    /**
     *@category function to format and return user tickets
     *
     *@param  string  $segment
     *
     *@return builder
     */
    public function formatUserTickets($segment)
    {
        $convert_to_array = explode('/', $segment);
        $user_id = $convert_to_array[2];
        $user = \DB::table('users')->select('role', 'id')->where('id', '=', $user_id)->first();
        $table = $this->table();
        if ($user->role == 'user') {
            $table = $table->leftJoin('ticket_status', 'tickets.status', '=', 'ticket_status.id')
                     ->where('tickets.user_id', '=', $user->id)
                     ->where('ticket_status.name', $convert_to_array[3]);
        } else {
            $table = $table->leftJoin('ticket_status', 'tickets.status', '=', 'ticket_status.id')
                    ->where('tickets.assigned_to', '=', $user->id)
                    ->where('ticket_status.name', $convert_to_array[3]);
        }

        return $table;
    }
}
