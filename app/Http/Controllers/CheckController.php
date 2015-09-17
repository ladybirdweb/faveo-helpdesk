<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Agent\Teams;
use App\Model\Agent\Assign_team_agent;
use DB;
use Config;
use Redirect;

class CheckController extends Controller {

    public function getcheck(Teams $team, Assign_team_agent $team_assign_agent) {
        if(Config::get('database.install') == '%0%')
        {
            return Redirect::route('license');
        }

        $table = $team_assign_agent->where('agent_id', 1)->first();
        $teams = $team->lists('id', 'name');

        $assign = $team_assign_agent->where('agent_id', 1)->lists('team_id');


        return view('themes.check', compact('teams', 'assign', 'table'));
    }

    public function postcheck($id, Assign_team_agent $team_assign_agent, Request $request) {
        $table = $team_assign_agent->where('agent_id', 1);
        $table->delete();

        $requests = $request->input('team_id');

        foreach ($requests as $req) {
            DB::insert('insert into team_assign_agent (team_id, agent_id) values (?,?)', [$req, $id]);
        }
    }

}
