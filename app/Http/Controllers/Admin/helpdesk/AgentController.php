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
use App\Model\helpdesk\Utility\CountryCode;
use App\Model\helpdesk\Utility\Timezones;
use App\User;
// classes
use DB;
use Exception;
use GeoIP;
use Hash;
use Lang;

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
    public function create(Timezones $timezone, Groups $group, Department $department, Teams $team_all, CountryCode $code)
    {
        try {
            // gte all the teams
            $team = $team_all->where('status', '=', 1)->get();
            // get all the timezones
            $timezones = $timezone->get();
            // get all the groups
            $groups = $group->where('group_status', '=', 1)->get();
            // get all department
            $departments = $department->get();
            // list all the teams in a single variable
            $teams = $team->pluck('id', 'name')->toArray();
            $location = GeoIP::getLocation();
            $phonecode = $code->where('iso', '=', $location->iso_code)->first();
            // returns to the page with all the variables and their datas
            $send_otp = DB::table('common_settings')->select('status')->where('option_name', '=', 'send_otp')->first();

            return view('themes.default1.admin.helpdesk.agent.agents.create', compact('teams', 'timezones', 'groups', 'departments', 'team', 'send_otp'))->with('phonecode', $phonecode->phonecode);
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
        if ($request->get('country_code') == '' && ($request->get('phone_number') != '' || $request->get('mobile') != '')) {
            return redirect()->back()->with(['fails2' => Lang::get('lang.country-code-required-error'), 'country_code' => 1])->withInput();
        } else {
            $code = CountryCode::select('phonecode')->where('phonecode', '=', $request->get('country_code'))->get();
            if (!count($code)) {
                return redirect()->back()->with(['fails2' => Lang::get('lang.incorrect-country-code-error'), 'country_code' => 1])->withInput();
            }
        }
        // fixing the user role to agent
        $user->fill($request->except(['group', 'primary_department', 'agent_time_zone', 'mobile']))->save();
        if ($request->get('mobile')) {
            $user->mobile = $request->get('mobile');
        } else {
            $user->mobile = null;
        }
        $user->assign_group = $request->group;
        $user->primary_dpt = $request->primary_department;
        $user->agent_tzone = $request->agent_time_zone;
        // generate password and has immediately to store
        $password = $this->generateRandomString();
        $user->password = Hash::make($password);
        // fetching all the team details checked for this user
        $requests = $request->input('team');
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
            $name = $user->first_name;
            $email = $user->email;
            if ($request->input('send_email')) {
                try {
                    // send mail on registration
                    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $email], $message = ['subject' => null, 'scenario' => 'registration-notification'], $template_variables = ['user' => $name, 'email_address' => $email, 'user_password' => $password]);
                } catch (Exception $e) {
                    // returns if try fails
                    return redirect('agents')->with('warning', Lang::get('lang.agent_send_mail_error_on_agent_creation'));
                }
            }
            // returns for the success case
            if ($request->input('active') == '0' || $request->input('active') == 0) {
                event(new \App\Events\LoginEvent($request));
            }

            return redirect('agents')->with('success', Lang::get('lang.agent_creation_success'));
        } else {
            // returns if fails
            return redirect('agents')->with('fails', Lang::get('lang.failed_to_create_agent'));
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
    public function edit($id, User $user, Assign_team_agent $team_assign_agent, Timezones $timezone, Groups $group, Department $department, Teams $team, CountryCode $code)
    {
        try {
            $location = GeoIP::getLocation();
            $phonecode = $code->where('iso', '=', $location->iso_code)->first();
            $user = $user->whereId($id)->first();
            $team = $team->where('status', '=', 1)->get();
            $teams1 = $team->pluck('name', 'id');
            $timezones = $timezone->get();
            $groups = $group->where('group_status', '=', 1)->get();
            $departments = $department->get();
            $table = $team_assign_agent->where('agent_id', $id)->first();
            $teams = $team->pluck('id', 'name')->toArray();
            $assign = $team_assign_agent->where('agent_id', $id)->pluck('team_id')->toArray();

            return view('themes.default1.admin.helpdesk.agent.agents.edit', compact('teams', 'assign', 'table', 'teams1', 'user', 'timezones', 'groups', 'departments', 'team'))->with('phonecode', $phonecode->phonecode);
        } catch (Exception $e) {
            return redirect('agents')->with('fail', Lang::get('lang.failed_to_edit_agent'));
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
        if ($request->get('country_code') == '' && ($request->get('phone_number') != '' || $request->get('mobile') != '')) {
            return redirect()->back()->with(['fails2' => Lang::get('lang.country-code-required-error'), 'country_code' => 1])->withInput();
        } else {
            $code = CountryCode::select('phonecode')->where('phonecode', '=', $request->get('country_code'))->get();
            if (!count($code)) {
                return redirect()->back()->with(['fails2' => Lang::get('lang.incorrect-country-code-error'), 'country_code' => 1])->withInput();
            }
        }
        // storing all the details
        $user = $user->whereId($id)->first();
        $daylight_save = $request->input('daylight_save');
        $limit_access = $request->input('limit_access');
        $directory_listing = $request->input('directory_listing');
        $vocation_mode = $request->input('vocation_mode');
        //==============================================
        $table = $team_assign_agent->where('agent_id', $id);
        $table->delete();
        $requests = $request->input('team');
        // inserting team details
        foreach ($requests as $req) {
            DB::insert('insert into team_assign_agent (team_id, agent_id) values (?,?)', [$req, $id]);
        }
        //Todo For success and failure conditions
        try {
            if ($request->input('country_code') != '' or $request->input('country_code') != null) {
                $user->country_code = $request->input('country_code');
            }
            $user->mobile = ($request->input('mobile') == '') ? null : $request->input('mobile');
            $user->fill($request->except('daylight_save', 'limit_access', 'directory_listing', 'vocation_mode', 'assign_team', 'mobile'));
            $user->assign_group = $request->group;
            $user->primary_dpt = $request->primary_department;
            $user->agent_tzone = $request->agent_time_zone;
            $user->save();

            return redirect('agents')->with('success', Lang::get('lang.agent_updated_sucessfully'));
        } catch (Exception $e) {
            return redirect('agents')->with('fails', Lang::get('lang.unable_to_update_agent').'<li>'.$e->errorInfo[2].'</li>');
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
            $error = Lang::get('lang.this_staff_is_related_to_some_tickets');
            $user->id;
            $user->delete();

            throw new \Exception($error);

            return redirect('agents')->with('success', Lang::get('lang.agent_deleted_sucessfully'));
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
