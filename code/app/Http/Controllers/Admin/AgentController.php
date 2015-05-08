<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequest;
use App\Http\Requests\AgentUpdate;
use App\Model\Agent\Assign_team_agent;
use App\Model\Agent\Department;
use App\Model\Agent\Groups;
use App\Model\Agent\Teams;
use App\Model\Utility\Timezones;
use App\User;
use DB;

/**
 * AgentController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class AgentController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return Response
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * get index page
	 * @param type User $user
	 * @return type Response
	 */
	public function index(User $user) {
		try {
			$user = $user->where('role', 'agent')->get();
			return view('themes.default1.admin.agent.agents.index', compact('user'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * @param type Assign_team_agent $team_assign_agent
	 * @param type Timezones $timezone
	 * @param type Groups $group
	 * @param type Department $department
	 * @param type Teams $team
	 * @return type Response
	 */
	public function create(Assign_team_agent $team_assign_agent, Timezones $timezone, Groups $group, Department $department, Teams $team) {
		try {
			$team = $team->get();
			//$agents = $agent->get();
			$timezones = $timezone->get();
			$groups = $group->get();
			$departments = $department->get();
			$teams = $team->lists('id', 'name');
			//$assign = $team_assign_agent->where('agent_id',$id)->lists('team_id');
			//$assign = $team_assign_agent->where('agent_id',1)->lists('team_id');
			return view('themes.default1.admin.agent.agents.create', compact('assign', 'teams', 'agents', 'timezones', 'groups', 'departments', 'team'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type User $user
	 * @param type AgentRequest $request
	 * @param type Assign_team_agent $team_assign_agent
	 * @return type Response
	 */
	public function store(User $user, AgentRequest $request, Assign_team_agent $team_assign_agent) {
		try {
			//$agent -> fill($request->except('team_id'))->save();
			/* Insert to user table */
			$user->role = 'agent';
			$user->fill($request->input())->save();
			// $teams = $request->input('assign_team');
			// $imp =implode(',', $teams);
			// $agent->assign_team = $imp;
			$requests = $request->input('team_id');
			$id = $user->id;
			foreach ($requests as $req) {
				DB::insert('insert into team_assign_agent (team_id, agent_id) values (?,?)', [$req, $id]);
			}
			/* Succes And Failure condition */
			if ($user->save() == true) {
				return redirect('agents')->with('success', 'Agent Created sucessfully');
			} else {
				return redirect('agents')->with('fails', 'Agent can not Create');
			}
		} catch (Exception $e) {
			return redirect('agents')->with('fails', 'Agent can not Create');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param type int $id
	 * @param type User $user
	 * @param type Assign_team_agent $team_assign_agent
	 * @param type Timezones $timezone
	 * @param type Groups $group
	 * @param type Department $department
	 * @param type Teams $team
	 * @return type Response
	 */
	public function edit($id, User $user, Assign_team_agent $team_assign_agent, Timezones $timezone, Groups $group, Department $department, Teams $team) {
		try {
			$user = $user->whereId($id)->first();
			$team = $team->get();
			$teams1 = $team->lists('name', 'id');
			$timezones = $timezone->get();
			$groups = $group->get();
			$departments = $department->get();
			// $selectedTeam= $user->assign_team;
			// $selectedTeams = explode(',',$selectedTeam);
			$table = $team_assign_agent->where('agent_id', $id)->first();
			$teams = $team->lists('id', 'name');
			$assign = $team_assign_agent->where('agent_id', $id)->lists('team_id');
			return view('themes.default1.admin.agent.agents.edit', compact('teams', 'assign', 'table', 'teams1', 'selectedTeams', 'user', 'timezones', 'groups', 'departments', 'team', 'exp', 'counted'));
		} catch (Exception $e) {
			return redirect('agents')->with('fail', 'No such file');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * @param type int $id
	 * @param type User $user
	 * @param type AgentUpdate $request
	 * @param type Assign_team_agent $team_assign_agent
	 * @return type Response
	 */
	public function update($id, User $user, AgentUpdate $request, Assign_team_agent $team_assign_agent) {
		try {
			//$agents = $agent -> whereId($id) -> first();
			$user = $user->whereId($id)->first();
			$daylight_save = $request->input('daylight_save');
			$limit_access = $request->input('limit_access');
			$directory_listing = $request->input('directory_listing');
			$vocation_mode = $request->input('vocation_mode');
			//$role=$request->input('role');
			//dd($account_status);
			// $agents->daylight_save=$daylight_save;
			// $agents->limit_access=$limit_access;
			// $agents->directory_listing=$directory_listing;
			// $agents->vocation_mode=$vocation_mode;
			//==============================================
			$user->daylight_save = $daylight_save;
			$user->limit_access = $limit_access;
			$user->directory_listing = $directory_listing;
			$user->vocation_mode = $vocation_mode;
			//$user->role=$role;
			//==============================================
			$table = $team_assign_agent->where('agent_id', $id);
			$table->delete();
			$requests = $request->input('team_id');
			foreach ($requests as $req) {
				DB::insert('insert into team_assign_agent (team_id, agent_id) values (?,?)', [$req, $id]);
			}
			//Todo For success and failure conditions
			//$agents->fill($request->except('daylight_save','limit_access','directory_listing','vocation_mode','assign_team'))->save();
			$user->fill($request->except('daylight_save', 'limit_access', 'directory_listing', 'vocation_mode', 'assign_team'))->save();
			return redirect('agents')->with('success', 'Agent Updated sucessfully');
		} catch (Exception $e) {
			return redirect('agents')->with('fails', 'Agent did not update');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @param type User $user
	 * @param type Assign_team_agent $team_assign_agent
	 * @return type Response
	 */
	public function destroy($id, User $user, Assign_team_agent $team_assign_agent) {
		try {
			/* Becouse of foreign key we delete team_assign_agent first */
			$team_assign_agent = $team_assign_agent->where('agent_id', $id);
			$team_assign_agent->delete();
			$user = $user->whereId($id)->first();
			if ($user->delete()) {
				return redirect('agents')->with('success', 'Agent Deleted sucessfully');
			} else {
				return redirect('agents')->with('fails', 'Agent can not  Delete ');
			}
		} catch (Exception $e) {
			return redirect('agents')->with('fails', 'Agent can not  Delete if the team Excist');
		}
	}
}
