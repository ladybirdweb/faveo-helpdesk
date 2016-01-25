<?php namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Controller;

// requests
use App\Http\Requests\helpdesk\TeamRequest;
use App\Http\Requests\helpdesk\TeamUpdate;

// models
use App\Model\helpdesk\Agent\Assign_team_agent;
use App\Model\helpdesk\Agent\Teams;
use App\User;

// classes
use DB;
use Exception;

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
			return view('themes.default1.admin.helpdesk.agent.teams.index', compact('assign_team_agent', 'teams'));
		} catch (Exception $e) {
			return redirect()->back()->with('fails',$e->errorInfo[2]);
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
			return view('themes.default1.admin.helpdesk.agent.teams.create', compact('user'));
		} catch (Exception $e) {
			return redirect()->back()->with('fails',$e->errorInfo[2]);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type Teams $team
	 * @param type TeamRequest $request
	 * @return type Response
	 */
	public function store(Teams $team, TeamRequest $request) {
		
			if($request->team_lead){
				$team_lead = $request->team_lead;
			} else {
				$team_lead = null;
			}
			$team->team_lead = $team_lead;
		try {
			/* Check whether function success or not */
			$team->fill($request->except('team_lead'))->save();
			/* redirect to Index page with Success Message */
			return redirect('teams')->with('success', 'Teams  Created Successfully');
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('teams')->with('fails', 'Teams can not Create'.'<li>'.$e->errorInfo[2].'</li>');
		}
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
			$agent_team = $assign_team_agent->where('team_id', $id)->get();
			$agent_id = $agent_team->lists('agent_id', 'agent_id');
			return view('themes.default1.admin.helpdesk.agent.teams.edit', compact('agent_id', 'user', 'teams', 'allagents'));
		} catch (Exception $e) {
			return redirect()->back()->with('fails',$e->errorInfo[2]);
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
		
			$teams = $team->whereId($id)->first();
			//updating check box
			if($request->team_lead){
				$team_lead = $request->team_lead;
			} else {
				$team_lead = null;
			}
			$teams->team_lead = $team_lead;
			$teams->save();

			$alert = $request->input('assign_alert');
			$teams->assign_alert = $alert;
			$teams->save(); //saving check box
			//updating whole field
			/* Check whether function success or not */
		try {				
			$teams->fill($request->except('team_lead'))->save();
			/* redirect to Index page with Success Message */
			return redirect('teams')->with('success', 'Teams  Updated Successfully');
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('teams')->with('fails', 'Teams  can not Update'.'<li>'.$e->errorInfo[2].'</li>');
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
			$tickets = DB::table('tickets')->where('team_id','=',$id)->update(['team_id' => null]);
			/* Check whether function success or not */
			$teams->delete();
			/* redirect to Index page with Success Message */
			return redirect('teams')->with('success', 'Teams  Deleted Successfully');
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('teams')->with('fails', 'Teams can not Delete'.'<li>'.$e->errorInfo[2].'</li>');
		}
	}
}
