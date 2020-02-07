<?php

namespace App\Http\Controllers\Agent\helpdesk\Filter;

//requests
use Illuminate\Http\Request;
use App\Http\Requests;
//controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\helpdesk\TicketController;
//models
use App\Model\helpdesk\Filters\Label;
use App\Model\helpdesk\Filters\Filter;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\TicketStatusType;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\DepartmentAssignAgents;
use App\Model\helpdesk\Manage\Tickettype;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Manage\Help_topic;
//classes
use DB;
use Auth;
use Datatables;
use UTC;
use App\User;
use Lang;
use App\Model\helpdesk\Agent\Assign_team_agent;

	/**
	* -----------------------------------------------------------------------------
	* FilterController
	* -----------------------------------------------------------------------------.
	*
	*
	* @author Manish Verma <manish.verma@ladybirdweb.com>
	* @copyright (c) 2017, Ladybird Web Solution
	* @package Class for handle ticket fetch request and alows filteration of the records
	* @version v2.0
	*/
class RelationFilterController extends Controller
{
	protected $request;
	
	/**
	 * @category constructor function
	 * @param Array/Object $request
	 * @return null
	 *
	 */
	public function __construct(Request $req)
	{
		$this->middleware(['auth', 'role.agent']);
		$this->request = $req;
		$this->gmt = getGMT();
	}

	/**
	 * @category function to handle ticket table/filteration request and build tables
	 * @param Array/Object $request
	 * @return json response //build by getTable() function in TicketController
	 *
	 */
	public function getFilter(Request $request)
	{
		$tickets = $this->table();
		if ($request->has('segment')){
			$segment = $this->request->input('segment');
			$tickets = $this->formatUserTickets($segment);
		} else {
			if ($request->has('api') && $request->get('api') == '1'){
				$inputs = [];
				foreach ($request->all() as $key => $value){
					if ($key != 'api' && $key != 'token' && $key != 'page' && $key != 'sort-by' && $key != 'order' && $key != 'records_per_page'){
						$inputs[$key] = explode(",", $value);//
					}
				};
				return $tickets = $this->checkRequestIsCorrect($inputs, $tickets);
			} else {
				$inputs = json_decode(htmlspecialchars_decode($request->get('options')));
				$tickets = $this->checkRequestIsCorrect((array)$inputs, $tickets);
			}
		}

		return \Ttable::getTableWithRelation($tickets);

		// dd($tickets->take(10)->orderBy('id')->get());
		 return $tickets->paginate(10, ['id', 'ticket_number', 'dept_id', 'user_id', 'assigned_to', 'team_id', 'status', 'priority_id', 'source', 'sla', 'help_topic_id', 'type', \DB::raw('CONVERT_TZ(tickets.created_at, "+00:00", "'.$this->gmt.'") as created'), \DB::raw('CONVERT_TZ(tickets.duedate, "+00:00", "'.$this->gmt.'") as duedate')])->toArray();
	}

	/**
	 * @category function to check of all the parameters passed to the URL are correct or not
	 * @param Array $inputs
	 * @return boolean true/false
	 */
	public function checkRequestIsCorrect($inputs, $tickets)
	{
		$available_options = [
			'status', 'sla', 'departments', 'source', 'created-by',
			'assigned-to', 'priority', 'help-topic', 'tags', 'labels',
			'types', 'show', 'assigned', 'due-on', 'updated-daterange',
			'created-daterange', 'updated', 'created',
			//not used yet

			'last-response-by',
			'ticket-number',
			'message'
		];

		$mytickets = false;
		if ($inputs['show'][0] == 'mytickets'){
			$mytickets = true;
		}
		ksort($inputs);
		$custom_fields = [];
		foreach ($inputs as $key => $value){
		    if (strpos($key, 'custom-') !== false){
		        unset($inputs[$key]);
		        $key = explode('custom-', $key);
		        $custom_fields[$key[1]] = $value;
		    }
		}
		if (count($custom_fields) > 0){
		    $tickets = $this->filterTableByCustomField($custom_fields, $tickets);
		}
		foreach ($inputs as $key => $input){
			if (!in_array($key, $available_options)){
				$tickets = $tickets->where('tickets.id', '=', null);
			} else {
				$tickets = $this->filterByInputs($key, $input, $mytickets, $tickets);
			}
		}
		return $tickets;
	}

	/**
	 * @category function to filter tickets based on user input requests
	 * @param string $input, $value, $tickets
	 * @return builder $tickets
	 */
	public function filterByInputs($input, $value, $is_mytickets, $tickets)
	{
		switch ($input) {
			case 'status':
				$tickets = $this->filterTicketByRelation($tickets, 'statuses', 'name', $value);
			break;
			
			case 'sla':
				$tickets = $this->filterTicketByRelation($tickets, 'slaPlan', 'name', $value);
			break;
			
			case 'departments':
				$tickets = $this->departmentFilter($value, $is_mytickets, $tickets);
			break;
			
			case 'source':
				$tickets = $this->filterTicketByRelation($tickets, 'sources', 'name', $value);
			break;
			
			case 'created-by':
				$users = [];
				foreach ($value as $username){
					array_push($users, substr($username, 2, strlen($username)));
				}
				$tickets = $this->filterTicketByRelation($tickets, 'user', 'user_name', $users, true, 'creator');
			break;
			
			case 'assigned-to':
				$ticket = $this->filterByAssigned($value, $tickets);
			break;
			
			case 'priority':
				$tickets = $this->filterTicketByRelation($tickets, 'priority', 'priority', $value);
			break;
			
			case 'help-topic':
				$tickets = $this->filterTicketByRelation($tickets, 'helptopic', 'topic', $value);
			break;

		    case 'tags':
				$tickets = $this->filterTicketByRelation($tickets, 'filter', 'value', $value);
			break;

			case 'labels':
				$tickets = $this->filterTicketByRelation($tickets, 'filter', 'value', $value);
			break;

			case 'types':
				$ticket = $this->filterTicketByRelation($tickets, 'types', 'name', $value);
			break;
			
			case 'show':
				$tickets = $this->showPage($value, $tickets);
			break;

			case 'assigned':
				if ($value[0] == ""){
					$tickets = $tickets;
				} else {
					if ($value[0] == 0 || $value[0] == '0'){
						$tickets = $tickets->where(function ($query) {
							$query->where(function ($query2) {
								$query2->where('team_id', '=', 0)
									->orWhere('team_id', '=', null);
							})->where(function ($query3) {
									$query3->where('assigned_to', '=', 0)
								->orWhere('assigned_to', '=', null);
							});
						});
					} elseif ($value[0] == 1 || $value[0] == '1'){
						$tickets = $tickets->where(function ($query) {
							$query->where(function ($query2) {
								$query2->where('team_id', '!=', 0)
									->Where('team_id', '!=', null);
							})->orwhere(function ($query3) {
									$query3->where('assigned_to', '!=', 0)
								->Where('assigned_to', '!=', null);
							});
						});
					} else {
					}
				}
			break;
				
			case 'created':
				$tickets = $this->filterByDate('create', $value, $tickets);
			break;

			case 'updated':
				$tickets = $this->filterByDate('update', $value, $tickets);
			break;

			case 'due-on':
				$tickets = $this->filterByDate('due-today', $value, $tickets);
			break;

			case 'updated-daterange':
				$tickets = $this->filterByDate('update', $value, $tickets);
			break;

			case 'created-daterange':
				$tickets = $this->filterByDate('create', $value, $tickets);
			break;

			case 'last-response-by':
				if ($value[0] == 'Client') {
					
					$tickets = $tickets->whereHas('threadSelectedFields', function ($query) {
						$query->having('poster', '=', 'client');
					});
				} else {
					$tickets = $tickets->whereHas('threadSelectedFields', function ($query) {
						$query->having('poster', '<>', 'client');
					});
				}
			break;
			case 'ticket-number':
				$tickets = $tickets->whereIn('tickets.ticket_number', $value);
				return $tickets;
				break;
			default:
				$tickets = $tickets->where('id', '=', null);
			break;
		}
		return $tickets;
	}

	/**
	 * @category function to format query builder for filter results by relationships
	 * @param string $relation(name of relation), string $column(name of column to use in where condition)
	 * array $value(values to check in where condition), boolean $related_to_user specifies type of
	 * relation
	 * @return builder $tickets
	 */
	public function filterTicketByRelation($tickets, $releation, $column, $value, $related_to_user = false)
	{
		if ($related_to_user){
			$tickets = $tickets->whereHas($releation, function ($query) use ($value) {
				$query->whereIn('email', $value)->orWhereIn('user_name', $value);
			});
		} else {
			$tickets = $tickets->whereHas($releation, function ($query) use ($column, $value) {
				$query->whereIn($column, $value);
			});
		}
		return $tickets;
	}

	/**
	 * @category function to build basic query builder for ticket tables
	 * @param null
	 * @var $tickets
	 * @return builder $tickets
	 */
	public function table()
	{
			// $tickets = new Tickets();
			$tickets = Tickets::select('tickets.id as id', 'ticket_number', 'dept_id', 'tickets.user_id', 'assigned_to', 'team_id', 'status', 'priority_id', 'tickets.source', 'sla', 'help_topic_id',  \DB::raw('CONVERT_TZ(tickets.created_at, "+00:00", "'.$this->gmt.'") as created'),\DB::raw('CONVERT_TZ(tickets.updated_at, "+00:00", "'.$this->gmt.'") as last_response'), \DB::raw('CONVERT_TZ(tickets.duedate, "+00:00", "'.$this->gmt.'") as duedate'), 'is_resolution_sla')
				//department details
				->with(['departments' => function ($query) {
					$query->addSelect('id', 'name as department_name');
				}])
				//requester details
				->with(['user' => function ($query) {
					$query->addSelect('id', 'user_name', 'first_name', 'last_name', 'email', 'profile_pic');
				}])
				//assigned agent details (if any)
				->with(['assigned' => function ($query) {
					$query->addSelect('id', 'user_name', 'first_name', 'last_name', 'email', 'profile_pic');
				}])
				//assigned team details (if any)
				->with(['assignedTeam' => function ($query) {
					$query->addSelect('id', 'name as team_name');
				}])
				// ticket status details
				->with(['statuses' => function ($query) {
					$query->addSelect('id', 'name as status', 'purpose_of_status');
				}])
				//ticket priority details
				->with(['priority' => function ($query) {
					$query->addSelect(['priority_id', 'priority', 'priority_color']);
				}])
				//get ticket source
				->with(['sources' => function ($query) {
					$query->addSelect('id', 'name as source', 'css_class as source_icon');
				}])
				// ticket help topic
				->with(['slaPlan' => function ($query) {
					$query->addSelect('id', 'name as sla');
				}])
				//ticket SLA
				->with(['helptopic' => function ($query) {
					$query->addSelect('id', 'topic as help_topic');
				}])
				->with(['filter' => function ($query) {
					$query->addSelect('ticket_id', 'value', 'key');
				}])
				->with(['types' => function ($query) {
					$query->addSelect('id', 'name');
				}])
				->with(['formdata'], function ($query) {
					$query->addSelect('id', 'ticket_id', 'content', 'key');
				})
				->with(['threadSelectedFields'], function(){
					$query->addSelect('id', 'ticket_id');
				})->groupBy('tickets.id');
				return $tickets;
	}


	/**
	 * @category function to filter tickets builder based on agent/admin departments
	 * @param array $value //requested department, $tickets
	 * @var array $departmentTickets
	 * @return $tickets
	 */
	public function departmentFilter($value, $is_mytickets, $tickets)
	{
		$tickets = $this->userIsAgent($tickets);
		// Admin account has global access by default
		if (sizeof($value) == 1 && (strcasecmp($value[0], 'all') == 0)){
			return $tickets;
		}
		$tickets = $this->filterTicketByRelation($tickets, 'departments', 'name', $value);
		if (Auth::user()->role == 'agent'){
			//Cehck agent has global access for their account
			$ticket_policy = new \App\Policies\TicketPolicy();
			if (!$ticket_policy->globalAccess()){
				$id=Auth::user()->id;
				$dept=DepartmentAssignAgents::where('agent_id', '=', $id)->pluck('department_id')->toArray();
				if (sizeof($value) == 1 && (strcasecmp($value[0], 'all') == 0)){
					$tickets = $this->filterTicketByRelation($tickets, 'departments', 'id', $dept);
					return $tickets;
				} else {
					$requested_dept = Department::whereIn('name', $value)->pluck('id')->toArray();
					if (!count(array_intersect($requested_dept, $dept)) == count($requested_dept)){
						$tickets = $this->filterTicketByRelation($tickets, 'departments', 'name', [null]);
					}
				}
			}
		}
		return $tickets;
	}

	/**
	 * @category function to filter the tickets by assigned team or agents
	 * @param string array $name, builder $tickets
	 * @var array $users (stores id's of agents and admin),
	 *array $teams (stores ids of teams), array asssigned merged arrya of unique elements in $teams and $users
	 * @return builder $tickets
	 */
	public function filterByAssigned($value, $tickets)
	{
		$team_array = [];
		$agent_array = [];
		foreach ($value as $value){
			if (substr($value, 0, 2) == 'a-'){
				array_push($agent_array, substr($value, 2, strlen($value)));
			} elseif (substr($value, 0, 2) == 't-'){
				array_push($team_array, substr($value, 2, strlen($value)));
			}
		}
		$tickets = $tickets->whereHas('assigned', function ($query) use ($agent_array) {
			$query->whereIn('email', $agent_array)->orWhereIn('user_name', $agent_array);
		})->orWhereHas('assignedTeam', function ($query) use ($team_array) {
			$query->whereIn('name', $team_array);
		});
		return $tickets;
	}

	/**
	 * @category function to filter the tickets by values of custom form fields
	 * @param string array $fields, builder $ticktes
	 *array $teams (stores ids of teams), array asssigned merged arrya of unique elements in $teams and $users
	 * @return builder $tickets
	 */
	public function filterTableByCustomField($fields, $tickets)
	{
		$tickets = $tickets->whereHas('formdata', function ($query) use ($fields) {
			foreach ($fields as $key => $value){
				$query->where([
					['content', '=', $value[0]],
					['key', '=', $key]
				]);
			}
		});
		return $tickets;
	}

	/**
	 * @category function to filter the tickets based on show value in the request
	 * @param array $value(), builder object $tickets
	 * @return builder object $tickets
	 */
	public function showPage($value, $tickets)
	{
		$has_status = array_key_exists('status', (array)json_decode(htmlspecialchars_decode($this->request->get('options'))));
		switch ($value[0]) {
			case 'inbox':
				return $this->returnShowPageWithStatus($has_status, $tickets, 'open');
				break;
			
			case 'mytickets':

            $teamIds = Assign_team_agent::where('agent_id',Auth::user()->id)->pluck('team_id')->toArray();
			 if(\Auth::user()->role == "agent"){
            $agentId = getAgentbasedonPermission('global_access');
            if(!in_array(Auth::user()->id, $agentId)){
            $departmentIds = DepartmentAssignAgents::where('agent_id',Auth::user()->id)->pluck('department_id')->toArray();

            $tickets = $tickets->whereIn('tickets.dept_id',$departmentIds)->where(function($query) use ($teamIds) {
                            $query->where('tickets.assigned_to',Auth::user()->id)->orWhereIn('tickets.team_id', $teamIds);
                        });

				return $this->returnShowPageWithStatus($has_status, $tickets, 'open');
				break;
              }
            }

            $tickets = $tickets->Where('tickets.assigned_to', '=', Auth::user()->id)->orWhereIn('tickets.team_id', $teamIds);
				return $this->returnShowPageWithStatus($has_status, $tickets, 'open');
				break;

			case 'trash':
				return $this->returnShowPageWithStatus($has_status, $tickets, 'deleted');
				break;

			case 'followup':
				$tickets = $tickets->where('tickets.follow_up', '=', 1);
				return $this->returnShowPageWithStatus($has_status, $tickets, 'open');
				break;

			case 'overdue':
				$tickets = $tickets->where('isanswered', '=', 0)
					->whereNotNull('tickets.duedate')
					->where('duedate', '!=', '00-00-00 00:00:00')
					->where('duedate', '<', \Carbon\Carbon::now());
				return  $this->returnShowPageWithStatus($has_status, $tickets, 'open');

			case 'approval':
				return $this->returnShowPageWithStatus($has_status, $tickets, 'approval');
				break;

			case 'closed':
				return $this->returnShowPageWithStatus($has_status, $tickets, 'closed');

			case 'unapproved':
                                $ticket_policy = new \App\Policies\TicketPolicy();
                                if($ticket_policy->viewUnapprovedTickets()){
                                    return $this->returnShowPageWithStatus($has_status, $tickets, 'unapproved');
                                }

			default:
				$tickets = $tickets->where('tickets.id', '=', null);
				return $tickets;
				break;
		}
	}

	/**
	 * @category function to return builder for show filter after checking if input
	 * request has status or not
	 * @param boolean $has_status(if request has status filter values or not),
	 * Object $tickets, string $status(basic pupose if status)
	 * @return Object $tickets;
	 */
	public function returnShowPageWithStatus($has_status, $tickets, $status)
	{
		if ($has_status){
			return $tickets;
		}
		$tickets = $this->filterTicketByRelation($tickets, 'statuses', 'id', getStatusArray($status));
		return $tickets;
	}

	/**
     * @category function to filter table for various date option like created, last modified, duo date and overdue
     * @param string $type (to check type of filter to apply on date), string $value for filters, builder $table
     * @var array $date [start and end dates]
     * @return builder
     */
    public function filterByDate($type, $value, $table)
    {
        switch ($type) {
            case 'create':
                $date = $this->getDate($value);
                $table = $this->getTableAfterDateFilration($date, $table, 'create', $value[0]);
                return $table;
                break;
            case 'update':
                $date = $this->getDate($value);
                $table = $this->getTableAfterDateFilration($date, $table, 'update', $value[0]);
                return $table;
                break;
            case 'due-today':
                $date = $this->getDate($value);
                $table = $this->getTableAfterDateFilration($date, $table, 'due', $value[0]);
                return $table;
                break;
        }
    }

    /**
     * @category function to get start and end date to apply date filter
     * @param string $value
     * @var date string $start, date string $end
     * @return array of start and end date
     */
    public function getDate($value)
    {
        $dt = \Carbon\Carbon::now()->tz(timezone());
        switch ($value[0]) {
            case '5-minutes':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subMinutes(5)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;

            case '10-minutes':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subMinutes(10)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '15-minutes':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subMinutes(15)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '30-minutes':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subMinutes(30)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '1-hour':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subHour()->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '4-hours':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subHours(4)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '8-hours':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subHours(8)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '12-hours':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subHours(12)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '24-hours':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->subHours(24)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '15-days':
                $date = date('Y-m-d H:i:s');
                $end =  carbon($date)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date)->subDays(15)->tz(timezone())->startOfDay()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case '30-days':
                $date_end = date('Y-m-d H:i:s');
                $date_start = date('Y-m-d 00:00:00');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_start)->subDays(30)->tz(timezone())->startOfDay()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'this-week':
                $date_end = date('Y-m-d H:i:s');
                $start = carbon($date_end)->tz(timezone())->startOfWeek()->format('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'this-month':
                $date_end = date('Y-m-d H:i:s');
                $start = carbon($date_end)->tz(timezone())->startOfMonth()->format('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'this-year':
                $date_end = date('Y-m-d H:i:s');
                $end =  carbon($date_end)->tz(timezone())->format('Y-m-d H:i:s');
                $start = carbon($date_end)->tz(timezone())->startOfYear()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'today':
                $date = date('Y-m-d H:i:s');
                $start = carbon($date)->tz(timezone())->startOfDay()->format('Y-m-d H:i:s');
                $end = carbon($date)->tz(timezone())->endOFDay()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'yesterday':
                $date = date('Y-m-d H:i:s');
                $end = carbon($date)->subDay()->tz(timezone())->endOFDay()->format('Y-m-d H:i:s');
                $start = carbon($date)->subDay()->tz(timezone())->startOfDay()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'next-hour':
                $date_start = date('Y-m-d H:i:s');
                $start = carbon($date_start)->tz('UTC')->format('Y-m-d H:i:s');
                $end = carbon($date_start)->addHour()->tz('UTC')->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'next-4-hours':
                $date_start = date('Y-m-d H:i:s');
                $start = carbon($date_start)->tz('UTC')->format('Y-m-d H:i:s');
                $end = carbon($date_start)->addHours(4)->tz('UTC')->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'next-8-hours':
                $date_start = date('Y-m-d H:i:s');
                $start = carbon($date_start)->tz('UTC')->format('Y-m-d H:i:s');
                $end = carbon($date_start)->addHours(8)->tz('UTC')->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'next-12-hours':
                $date_start = date('Y-m-d H:i:s');
                $start = carbon($date_start)->tz('UTC')->format('Y-m-d H:i:s');
                $end = carbon($date_start)->addHours(12)->tz('UTC')->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'tomorrow':
                $date = date('Y-m-d H:i:s');
                $end = carbon($date)->addDay()->tz(timezone())->endOfDay()->format('Y-m-d H:i:s');
                $start = carbon($date)->addDay()->tz(timezone())->startOfDay()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'last-week':
                $date_start = date('Y-m-d 00:00:00');
                $date_end = date('Y-m-d 23:59:59');
                $start = carbon($date_start)->subWeek()->tz(timezone())->startOfWeek()->format('Y-m-d H:i:s');
                $end = carbon($date_end)->subWeek()->tz(timezone())->endOfWeek()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'last-month':
                $date_start = date('Y-m-d 00:00:00');
                $date_end = date('Y-m-d 23:59:59');
                $start = carbon($date_start)->subMonth()->tz(timezone())->startOfMonth()->format('Y-m-d H:i:s');
                $end = carbon($date_end)->subMonth()->tz(timezone())->endOfMonth()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
            
            case 'last-2-months':
                $date_start = date('Y-m-d 00:00:00');
                $date_end = date('Y-m-d 23:59:59');
                $start = carbon($date_start)->subMonths(2)->tz(timezone())->startOfMonth()->format('Y-m-d H:i:s');
                $end = carbon($date_end)->tz(timezone())->startOfMonth()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;

            case 'last-3-months':
                $date_start = date('Y-m-d 00:00:00');
                $date_end = date('Y-m-d 23:59:59');
                $start = carbon($date_start)->subMonths(3)->tz(timezone())->startOfMonth()->format('Y-m-d H:i:s');
                $end = carbon($date_end)->tz(timezone())->startOfMonth()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;

            case 'last-6-months':
                $date_start = date('Y-m-d 00:00:00');
                $date_end = date('Y-m-d 23:59:59');
                $start = carbon($date_start)->subMonths(6)->tz(timezone())->startOfMonth()->format('Y-m-d H:i:s');
                $end = carbon($date_end)->tz(timezone())->startOfMonth()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;

            case 'last-year':
                $date_start = date('Y-m-d 00:00:00');
                $date_end = date('Y-m-d 23:59:59');
                $start = carbon($date_start)->subYear()->tz(timezone())->startOfYear()->format('Y-m-d H:i:s');
                $end = carbon($date_end)->tz(timezone())->startOfYear()->format('Y-m-d H:i:s');
                return [$start, $end];
                break;
                // cases for due date

            case 'custom':
                return ['any'];
                break;
            case 'any-time':
                return ['any'];
                break;
            default:
                $custom_range = explode(' - ', $value[0]);
                if (count($custom_range) ==2) {
                    $start = $custom_range[0];
                    $end = $custom_range[1];
                    return [$start, $end];
                }
                return [];
                break;
        }
    }

    /**
     * @category function to apply date filters in table builder after
     *getting start and end date based on the type of date filter
     * @param array $dates, builder $table, $column (type of filter based on which column is being chosen), $value
     * @var string  $check_column (name of column), array $dates
     * @return builder
     */
    public function getTableAfterDateFilration($date, $table, $column, $value)
    {
        $check_column ='';
        $dates = [];
        if ($column == 'create') {
            $check_column = 'created';
        } elseif ($column == 'update') {
            $check_column = 'last_response';
        } else {
            $check_column = 'duedate';
        }
        if (count($date) == 2) {
        	$table = $table->having($check_column, '>=', $date[0])->having($check_column, '<=', $date[1]);
            if ($column == "due") {
                $table = $table->where('isanswered', '=', 0);
            }
        } elseif (count($date) == 1) {
        	// do nothing as filter expects anytime
        } else {
            $table = $table->where('tickets.id', '=', null);
        }
        return $table;
    }

    /**
     *@category function to update querybuilder according to user's role
     *@param $table querybuilder
     *@var $id, $dept
     *@return $table
     */
    public function userIsAgent($table)
    {
        if (Auth::user()->role == 'agent') {
            $ticket_policy = new \App\Policies\TicketPolicy();

            if($ticket_policy->globalAccess()){
              return $table;
            }

         
            else if($ticket_policy->restrictedAccess()){
              $table = $table->Where('tickets.assigned_to', '=', Auth::user()->id);
              return $table;
            }
            
            else{

                $id=Auth::user()->id;
            $dept=DepartmentAssignAgents::where('agent_id', '=', $id)->pluck('department_id')->toArray();
            $table = $table->where(function ($query) use ($dept) {
                $query->whereIn('tickets.dept_id', $dept)
                ->orWhere('assigned_to', '=', Auth::user()->id);
            });
            }

            
        }
        return $table;
    }
}
