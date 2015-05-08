<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\TeamUpdate;
use App\Model\Agent\Assign_team_agent;
use App\Model\Agent\Teams;
use App\User;

/**
 * TeamController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class TeamController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * get Index page
	 * @param type Teams $team
	 * @param type Assign_team_agent $assign_team_agent
	 * @return type Response
	 */
	public function index(Teams $team, Assign_team_agent $assign_team_agent) {
		try {
			$teams = $team->get();
			/*  find out the Number of Members in the Team */
			$id = $teams->lists('id');
			$assign_team_agent = $assign_team_agent->get();
			//dd($id);
			// foreach($id as $i)
			// {
			// 	$assign_team_agent = $assign_team_agent->where('team_id',$i);
			// 	dd($assign_team_agent);
			// }
			return view('themes.default1.admin.agent.teams.index', compact('assign_team_agent', 'teams'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * @param type User $user
	 * @return type Response
	 */
	public function create(User $user) {
		try {
			$user = $user->get();
			return view('themes.default1.admin.agent.teams.create', compact('user'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type Teams $team
	 * @param type TeamRequest $request
	 * @return type Response
	 */
	public function store(Teams $team, TeamRequest $request) {
		try {
			/* Check whether function success or not */
			if ($team->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('teams')->with('success', 'Teams  Created Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('teams')->with('fails', 'Teams can not Create');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('teams')->with('fails', 'Teams can not Create');
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
	 * @param type $id
	 * @param type User $user
	 * @param type Assign_team_agent $assign_team_agent
	 * @param type Teams $team
	 * @return type Response
	 */
	public function edit($id, User $user, Assign_team_agent $assign_team_agent, Teams $team) {
		try {
			$user = $user->whereId($id)->first();
			$teams = $team->whereId($id)->first();
			//$allagents = $agent->get();
			/*  Gettting member of the team  */
			$agent_team = $assign_team_agent->where('team_id', $id)->get();
			//dd($agent_team);
			$agent_id = $agent_team->lists('agent_id', 'agent_id');
			// dd($agent_id);
			//$id  = $agent->lists('id');
			//dd($id);
			// foreach($agent_id as $aaaaa)
			// {
			// $agent 	=	$agent->where('id',$aaaaa)->first();
			// echo $agent;
			//  //
			// }
			return view('themes.default1.admin.agent.teams.edit', compact('agent_id', 'user', 'teams', 'allagents'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * @param type int $id
	 * @param type Teams $team
	 * @param type TeamUpdate $request
	 * @return type Response
	 */
	public function update($id, Teams $team, TeamUpdate $request) {
		try {
			$teams = $team->whereId($id)->first();
			//updating check box
			$alert = $request->input('assign_alert');
			$teams->assign_alert = $alert;
			$teams->save(); //saving check box
			//updating whole field
			/* Check whether function success or not */
			if ($teams->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('teams')->with('success', 'Teams  Updated Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('teams')->with('fails', 'Teams  can not Update');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('teams')->with('fails', 'Teams  can not Update');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @param type Teams $team
	 * @param type Assign_team_agent $assign_team_agent
	 * @return type Response
	 */
	public function destroy($id, Teams $team, Assign_team_agent $assign_team_agent) {
		try {
			$assign_team_agent->where('team_id', $id)->delete();
			$teams = $team->whereId($id)->first();
			/* Check whether function success or not */
			if ($teams->delete() == true) {
				/* redirect to Index page with Success Message */
				return redirect('teams')->with('success', 'Teams  Deleted Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('teams')->with('fails', 'Teams can not Delete');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('teams')->with('fails', 'Teams can not Delete');
		}
	}
}
