<?php

namespace App\Http\Controllers\Agent\helpdesk;

// controllers
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Controller;
// requests
// models
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Teams;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Form\Fields;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Settings\Alert;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\Email;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Collaborator;
use App\Model\helpdesk\Ticket\Ticket_Form_Data;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\User;
use Auth;
use DB;
use Exception;
// classes
use Hash;
use Illuminate\support\Collection;
use Input;
use Lang;
use Mail;
use PDF;
use UTC;

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

        return \Datatable::collection(new Collection($tickets))
                        ->addColumn('id', function ($ticket) {
                             return "<input type='checkbox' name='select_all[]' id='".$ticket->id."' onclick='someFunction(this.id)' class='selectval icheckbox_flat-blue' value='".$ticket->id."'></input>";
                        })
                        ->addColumn('subject', function ($ticket) {
                            $subject = DB::table('ticket_thread')->select('title')->where('ticket_id', '=', $ticket->id)->first();
                            if (isset($subject->title)) {
                                $string = $subject->title;
                                if (strlen($string) > 20) {
                                    $stringCut = substr($string, 0, 30);
                                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
                                }
                            } else {
                                $string = '(no subject)';
                            }
                            //collabrations
                            $collaborators = DB::table('ticket_collaborator')->where('ticket_id', '=', $ticket->id)->get();
                            $collab = count($collaborators);
                            if ($collab > 0) {
                                $collabString = '&nbsp;<i class="fa fa-users"></i>';
                            } else {
                                $collabString = null;
                            }
                            $threads = Ticket_Thread::where('ticket_id', '=', $ticket->id)->first(); //
                            $count = Ticket_Thread::where('ticket_id', '=', $ticket->id)->count(); //
                            $attachment = Ticket_attachments::where('thread_id', '=', $threads->id)->get();
                            $attachCount = count($attachment);
                            if ($attachCount > 0) {
                                $attachString = '&nbsp;<i class="fa fa-paperclip"></i>';
                            } else {
                                $attachString = '';
                            }

                            return "<a href='".route('ticket.thread', [$ticket->id])."' title='".$subject->title."'>".$string."&nbsp;<span style='color:green'>(".$count.")<i class='fa fa-comment'></i></span></a>".$collabString.$attachString;
                        })
                        ->addColumn('ticket_number', function ($ticket) {
                            return "<a href='".route('ticket.thread', [$ticket->id])."' title='".$ticket->ticket_number."'>#".$ticket->ticket_number.'</a>';
                        })
                        ->addColumn('priority', function ($ticket) {
                            $priority = DB::table('ticket_priority')->select('priority_desc', 'priority_color')->where('priority_id', '=', $ticket->priority_id)->first();

                            return '<span class="btn btn-'.$priority->priority_color.' btn-xs">'.$priority->priority_desc.'</span>';
                        })
                        ->addColumn('from', function ($ticket) {
                            $from = DB::table('users')->select('user_name')->where('id', '=', $ticket->user_id)->first();

                            return "<span style='color:#508983'>".$from->user_name.'</span>';
                        })
                        ->addColumn('Last Replier', function ($ticket) {
                            $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->where('is_internal', '=', 0)->max('id');
                            $TicketDatarow = Ticket_Thread::where('id', '=', $TicketData)->first();
                            $LastResponse = User::where('id', '=', $TicketDatarow->user_id)->first();
                            if ($LastResponse->role == 'user') {
                                $rep = '#F39C12';
                                $username = $LastResponse->user_name;
                            } else {
                                $rep = '#000';
                                $username = $LastResponse->first_name.' '.$LastResponse->last_name;
                                if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                    $username = $LastResponse->user_name;
                                }
                            }

                            return "<span style='color:".$rep."'>".$username.'</span>';
                        })
                        ->addColumn('assigned_to', function ($ticket) {
                            if ($ticket->assigned_to == null) {
                                return "<span style='color:red'>Unassigned</span>";
                            } else {
                                $assign = DB::table('users')->where('id', '=', $ticket->assigned_to)->first();

                                return "<span style='color:green'>".$assign->first_name.' '.$assign->last_name.'</span>';
                            }
                        })
                        ->addColumn('Last', function ($ticket) {
                            $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
                            $TicketDatarow = Ticket_Thread::select('updated_at')->where('id', '=', $TicketData)->first();

                            return UTC::usertimezone($TicketDatarow->updated_at);
                        })
                        ->searchColumns('subject', 'from', 'assigned_to', 'ticket_number', 'priority')
                        ->orderColumns('subject', 'from', 'assigned_to', 'Last Replier', 'ticket_number', 'priority', 'Last')
                        ->make();
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
            $tickets = Tickets::where('status', '=', '2')->where('dept_id', '=', $id)->get();
        }

        return \Datatable::collection(new Collection($tickets))
                        ->addColumn('id', function ($ticket) {
                             return "<input type='checkbox' name='select_all[]' id='".$ticket->id."' onclick='someFunction(this.id)' class='selectval icheckbox_flat-blue' value='".$ticket->id."'></input>";
                        })
                        ->addColumn('subject', function ($ticket) {
                            $subject = DB::table('ticket_thread')->select('title')->where('ticket_id', '=', $ticket->id)->first();
                            if (isset($subject->title)) {
                                $string = $subject->title;
                                if (strlen($string) > 20) {
                                    $stringCut = substr($string, 0, 30);
                                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
                                }
                            } else {
                                $string = '(no subject)';
                            }
                            //collabrations
                            $collaborators = DB::table('ticket_collaborator')->where('ticket_id', '=', $ticket->id)->get();
                            $collab = count($collaborators);
                            if ($collab > 0) {
                                $collabString = '&nbsp;<i class="fa fa-users"></i>';
                            } else {
                                $collabString = null;
                            }
                            $threads = Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
                            $count = Ticket_Thread::where('ticket_id', '=', $ticket->id)->count();
                            $attachment = Ticket_attachments::where('thread_id', '=', $threads->id)->get();
                            $attachCount = count($attachment);
                            if ($attachCount > 0) {
                                $attachString = '&nbsp;<i class="fa fa-paperclip"></i>';
                            } else {
                                $attachString = '';
                            }

                            return "<a href='".route('ticket.thread', [$ticket->id])."' title='".$subject->title."'>".$string."&nbsp;<span style='color:green'>(".$count.")<i class='fa fa-comment'></i></span></a>".$collabString.$attachString;
                        })
                        ->addColumn('ticket_number', function ($ticket) {
                            return "<a href='".route('ticket.thread', [$ticket->id])."' title='".$ticket->ticket_number."'>#".$ticket->ticket_number.'</a>';
                        })
                        ->addColumn('priority', function ($ticket) {
                            $priority = DB::table('ticket_priority')->select('priority_desc', 'priority_color')->where('priority_id', '=', $ticket->priority_id)->first();

                            return '<span class="btn btn-'.$priority->priority_color.' btn-xs">'.$priority->priority_desc.'</span>';
                        })
                        ->addColumn('from', function ($ticket) {
                            $from = DB::table('users')->select('user_name')->where('id', '=', $ticket->user_id)->first();

                            return "<span style='color:#508983'>".$from->user_name.'</span>';
                        })
                        ->addColumn('Last Replier', function ($ticket) {
                            $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->where('is_internal', '!=', 1)->max('id');
                            $TicketDatarow = Ticket_Thread::where('id', '=', $TicketData)->first();
                            $LastResponse = User::where('id', '=', $TicketDatarow->user_id)->first();
                            if ($LastResponse->role == 'user') {
                                $rep = '#F39C12';
                                $username = $LastResponse->user_name;
                            } else {
                                $rep = '#000';
                                $username = $LastResponse->first_name.' '.$LastResponse->last_name;
                                if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                    $username = $LastResponse->user_name;
                                }
                            }

                            return "<span style='color:".$rep."'>".$username.'</span>';
                        })
                        ->addColumn('assigned_to', function ($ticket) {
                            if ($ticket->assigned_to == null) {
                                return "<span style='color:red'>Usernassigned</span>";
                            } else {
                                $assign = DB::table('users')->where('id', '=', $ticket->assigned_to)->first();

                                return "<span style='color:green'>".$assign->first_name.' '.$assign->last_name.'</span>';
                            }
                        })
                        ->addColumn('Last', function ($ticket) {
                            $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
                            $TicketDatarow = Ticket_Thread::select('updated_at')->where('id', '=', $TicketData)->first();

                            return UTC::usertimezone($TicketDatarow->updated_at);
                        })
                        ->searchColumns('subject', 'from', 'assigned_to', 'ticket_number', 'priority')
                        ->orderColumns('subject', 'from', 'assigned_to', 'Last Replier', 'ticket_number', 'priority', 'Last')
                        ->make();
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
     *Show the list of In process tickets
     *@param $id int
     */
    public function getInProcessTickets($id) 
    {
        $dept = Department::where('name','=',$id)->first();
        if(Auth::user()->role == 'agent') {
        
            $tickets = Tickets::where('status','=','1')->where('assigned_to','>', 0)->where('dept_id','=', $id)->get();
        } else {
            $tickets = Tickets::where('status','=','1')->where('assigned_to','>', 0)->where('dept_id','=', $id)->get();
        }


        return \Datatable::collection(new Collection($tickets))
                        ->addColumn('id', function ($ticket) {
                             return "<input type='checkbox' name='select_all[]' id='".$ticket->id."' onclick='someFunction(this.id)' class='selectval icheckbox_flat-blue' value='".$ticket->id."'></input>";
                        })
                        ->addColumn('subject', function ($ticket) {
                            $subject = DB::table('ticket_thread')->select('title')->where('ticket_id', '=', $ticket->id)->first();
                            if (isset($subject->title)) {
                                $string = $subject->title;
                                if (strlen($string) > 20) {
                                    $stringCut = substr($string, 0, 30);
                                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
                                }
                            } else {
                                $string = '(no subject)';
                            }
                            //collabrations
                            $collaborators = DB::table('ticket_collaborator')->where('ticket_id', '=', $ticket->id)->get();
                            $collab = count($collaborators);
                            if ($collab > 0) {
                                $collabString = '&nbsp;<i class="fa fa-users"></i>';
                            } else {
                                $collabString = null;
                            }
                            $threads = Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
                            $count = Ticket_Thread::where('ticket_id', '=', $ticket->id)->count();
                            $attachment = Ticket_attachments::where('thread_id', '=', $threads->id)->get();
                            $attachCount = count($attachment);
                            if ($attachCount > 0) {
                                $attachString = '&nbsp;<i class="fa fa-paperclip"></i>';
                            } else {
                                $attachString = '';
                            }

                            return "<a href='".route('ticket.thread', [$ticket->id])."' title='".$subject->title."'>".$string."&nbsp;<span style='color:green'>(".$count.")<i class='fa fa-comment'></i></span></a>".$collabString.$attachString;
                        })
                        ->addColumn('ticket_number', function ($ticket) {
                            return "<a href='".route('ticket.thread', [$ticket->id])."' title='".$ticket->ticket_number."'>#".$ticket->ticket_number.'</a>';
                        })
                        ->addColumn('priority', function ($ticket) {
                            $priority = DB::table('ticket_priority')->select('priority_desc', 'priority_color')->where('priority_id', '=', $ticket->priority_id)->first();

                            return '<span class="btn btn-'.$priority->priority_color.' btn-xs">'.$priority->priority_desc.'</span>';
                        })
                        ->addColumn('from', function ($ticket) {
                            $from = DB::table('users')->select('user_name')->where('id', '=', $ticket->user_id)->first();

                            return "<span style='color:#508983'>".$from->user_name.'</span>';
                        })
                        ->addColumn('Last Replier', function ($ticket) {
                            $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->where('is_internal', '!=', 1)->max('id');
                            $TicketDatarow = Ticket_Thread::where('id', '=', $TicketData)->first();
                            $LastResponse = User::where('id', '=', $TicketDatarow->user_id)->first();
                            if ($LastResponse->role == 'user') {
                                $rep = '#F39C12';
                                $username = $LastResponse->user_name;
                            } else {
                                $rep = '#000';
                                $username = $LastResponse->first_name.' '.$LastResponse->last_name;
                                if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                    $username = $LastResponse->user_name;
                                }
                            }

                            return "<span style='color:".$rep."'>".$username.'</span>';
                        })
                        ->addColumn('assigned_to', function ($ticket) {
                            if ($ticket->assigned_to == null) {
                                return "<span style='color:red'>Usernassigned</span>";
                            } else {
                                $assign = DB::table('users')->where('id', '=', $ticket->assigned_to)->first();

                                return "<span style='color:green'>".$assign->first_name.' '.$assign->last_name.'</span>';
                            }
                        })
                        ->addColumn('Last', function ($ticket) {
                            $TicketData = Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
                            $TicketDatarow = Ticket_Thread::select('updated_at')->where('id', '=', $TicketData)->first();

                            return UTC::usertimezone($TicketDatarow->updated_at);
                        })
                        ->searchColumns('subject', 'from', 'assigned_to', 'ticket_number', 'priority')
                        ->orderColumns('subject', 'from', 'assigned_to', 'Last Replier', 'ticket_number', 'priority', 'Last')
                        ->make();

    }
}
