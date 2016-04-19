<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controller
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Controller;
// request
use App\Http\Requests\helpdesk\AgentRequest;
use App\Http\Requests\helpdesk\AgentUpdate;
// model
use App\Model\helpdesk\Agent\Assign_team_agent;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Groups;
use App\Model\helpdesk\Agent\Teams;
use App\Model\helpdesk\Utility\Timezones;
use App\User;
// classes
use DB;
use Exception;
use Hash;

/**
 * AgentController
 * This controller is used to CRUD Agents.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class AgentController extends Controller
{
    /**
     * Create a new controller instance.
     * constructor to check
     * 1. authentication
     * 2. user roles
     * 3. roles must be agent.
     *
     * @return void
     */
    public function __construct(PhpMailController $PhpMailController)
    {
        // creating an instance for the PhpmailController
        $this->PhpMailController = $PhpMailController;
        // checking authentication
        $this->middleware('auth');
        // checking admin roles
        $this->middleware('roles');
    }

    /**
     * Get all agent list page.
     *
     * @return type view
     */
    public function index()
    {
        try {
            return view('themes.default1.admin.helpdesk.agent.agents.index');
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * creating a new agent.
     *
     * @param Assign_team_agent $team_assign_agent
     * @param Timezones         $timezone
     * @param Groups            $group
     * @param Department        $department
     * @param Teams             $team_all
     *
     * @return type view
     */
    public function create(Timezones $timezone, Groups $group, Department $department, Teams $team_all)
    {
        try {
            // gte all the teams
            $team = $team_all->get();
            // get all the timezones
            $timezones = $timezone->get();
            // get all the groups
            $groups = $group->get();
            // get all department
            $departments = $department->get();
            // list all the teams in a single variable
            $teams = $team->lists('id', 'name');
            // returns to the page with all the variables and their datas
            return view('themes.default1.admin.helpdesk.agent.agents.create', compact('assign', 'teams', 'agents', 'timezones', 'groups', 'departments', 'team'));
        } catch (Exception $e) {
            // returns if try fails with exception meaagse
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * store a new agent.
     *
     * @param User              $user
     * @param AgentRequest      $request
     * @param Assign_team_agent $team_assign_agent
     *
     * @return type Response
     */
    public function store(User $user, AgentRequest $request)
    {
        // fixing the user role to agent
        $user->fill($request->input())->save();
        // generate password and has immediately to store
        $password = $this->generateRandomString();
        $user->password = Hash::make($password);
        // fetching all the team details checked for this user
        $requests = $request->input('team_id');
        // get user id of the inserted user detail
        $id = $user->id;
        // insert team
        foreach ($requests as $req) {
            // insert all the selected team id to the team and agent relationship table
            DB::insert('insert into team_assign_agent (team_id, agent_id) values (?,?)', [$req, $id]);
        }
        // save user credentails
        if ($user->save() == true) {
            // fetch user credentails to send mail
            $name = $user->user_name;
            $email = $user->email;
            try {
                // send mail on registration
                $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $email], $message = ['subject' => 'Password', 'scenario' => 'registration-notification'], $template_variables = ['user' => $name, 'email_address' => $email, 'user_password' => $password]);
            } catch (Exception $e) {
                // returns if try fails
                return redirect('agents')->with('fails', 'Some error occurred while sending mail to the agent. Please check email settings and try again');
            }
            // returns for the success case
            return redirect('agents')->with('success', 'Agent Created sucessfully');
        } else {
            // returns if fails
            return redirect('agents')->with('fails', 'Agent can not Create');
        }
    }

    /**
     * Editing a selected agent.
     *
     * @param type int               $id
     * @param type User              $user
     * @param type Assign_team_agent $team_assign_agent
     * @param type Timezones         $timezone
     * @param type Groups            $group
     * @param type Department        $department
     * @param type Teams             $team
     *
     * @return type Response
     */
    public function edit($id, User $user, Assign_team_agent $team_assign_agent, Timezones $timezone, Groups $group, Department $department, Teams $team)
    {
        try {
            $user = $user->whereId($id)->first();
            $team = $team->get();
            $teams1 = $team->lists('name', 'id');
            $timezones = $timezone->get();
            $groups = $group->get();
            $departments = $department->get();
            $table = $team_assign_agent->where('agent_id', $id)->first();
            $teams = $team->lists('id', 'name');
            $assign = $team_assign_agent->where('agent_id', $id)->lists('team_id');

            return view('themes.default1.admin.helpdesk.agent.agents.edit', compact('teams', 'assign', 'table', 'teams1', 'selectedTeams', 'user', 'timezones', 'groups', 'departments', 'team', 'exp', 'counted'));
        } catch (Exception $e) {
            return redirect('agents')->with('fail', 'No such file');
        }
    }

    /**
     * Update the specified agent in storage.
     *
     * @param type int               $id
     * @param type User              $user
     * @param type AgentUpdate       $request
     * @param type Assign_team_agent $team_assign_agent
     *
     * @return type Response
     */
    public function update($id, User $user, AgentUpdate $request, Assign_team_agent $team_assign_agent)
    {

        // storing all the details
        $user = $user->whereId($id)->first();
        $daylight_save = $request->input('daylight_save');
        $limit_access = $request->input('limit_access');
        $directory_listing = $request->input('directory_listing');
        $vocation_mode = $request->input('vocation_mode');
        //==============================================
        $table = $team_assign_agent->where('agent_id', $id);
        $table->delete();
        $requests = $request->input('team_id');
        // inserting team details
        foreach ($requests as $req) {
            DB::insert('insert into team_assign_agent (team_id, agent_id) values (?,?)', [$req, $id]);
        }
        //Todo For success and failure conditions
        try {
            $user->fill($request->except('daylight_save', 'limit_access', 'directory_listing', 'vocation_mode', 'assign_team'))->save();

            return redirect('agents')->with('success', 'Agent Updated sucessfully');
        } catch (Exception $e) {
            return redirect('agents')->with('fails', 'Agent did not update'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Remove the specified agent from storage.
     *
     * @param type              $id
     * @param User              $user
     * @param Assign_team_agent $team_assign_agent
     *
     * @throws Exception
     *
     * @return type Response
     */
    public function destroy($id, User $user, Assign_team_agent $team_assign_agent)
    {
        /* Becouse of foreign key we delete team_assign_agent first */
        error_reporting(E_ALL & ~E_NOTICE);
        $team_assign_agent = $team_assign_agent->where('agent_id', $id);
        $team_assign_agent->delete();
        $user = $user->whereId($id)->first();
        try {
            $error = 'This staff is related to some tickets';
            $user->id;
            $user->delete();
            throw new \Exception($error);

            return redirect('agents')->with('success', 'Agent Deleted sucessfully');
        } catch (\Exception $e) {
            return redirect('agents')->with('fails', $error);
        }
    }

    /**
     * Generate a random string for password.
     *
     * @param type $length
     *
     * @return string
     */
    public function generateRandomString($length = 10)
    {
        // list of supported characters
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // character length checked
        $charactersLength = strlen($characters);
        // creating an empty variable for random string
        $randomString = '';
        // fetching random string
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        // return random string
        return $randomString;
    }
}
