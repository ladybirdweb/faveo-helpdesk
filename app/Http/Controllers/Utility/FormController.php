<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Model\Custom\Form;
use App\Model\helpdesk\Agent\Assign_team_agent;
use App\Model\helpdesk\Agent\Teams;
use App\User;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**(Dependency places [create ticket (requester),deactivate agent(assign open ticket) ,team create(team lead)])
    * get requester in form
    * @param Request $request
    * @return json
    */
    public function requester(Request $request)
    {
        if ($request->has('team')) {
            $id = $request->team;
            $term = $request->input('term');
            $team = new Teams();
            $teams = $team->whereId($id)->first();

            $assign_team_agent = new Assign_team_agent();
            $agent_team = $assign_team_agent->where('team_id', $id)->get();

            $agent_id = $agent_team->pluck('agent_id', 'agent_id');

            $query = User::whereIn('id', $agent_id)->where('active', '=', 1)->where('ban', '!=', 1)->where('is_delete', '!=', 1)
                            ->when($term, function ($q) use ($term) {
                                $q->where(function ($query) use ($term) {
                                    $query->select('id', 'first_name', 'last_name', 'email', 'user_name', 'profile_pic')
                                    ->where('first_name', 'LIKE', '%'.$term.'%')
                                    ->orwhere('last_name', 'LIKE', '%'.$term.'%')
                                    ->orwhere('user_name', 'LIKE', '%'.$term.'%')
                                    ->orwhere('email', 'LIKE', '%'.$term.'%');
                                });
                            })->get();

            return $query;
        } else {
            $method = $request->input('type', 'agent', 'user', 'admin', 'agent-only');
            $user_ids = explode(',', $request->input('user_id', ''));
            if (count($user_ids) == 1 && $user_ids[0] == '') {
                $user_ids = '';
            }
            //$method = 'requester';
            //$user_ids = [];
            $user = new \App\User();
            $term = $request->input('term');
            $query = $user
                        ->leftJoin('user_assign_organization', 'users.id', '=', 'user_assign_organization.user_id')
                        ->leftJoin('organization', 'organization.id', '=', 'user_assign_organization.org_id')
                        ->when($term, function ($q) use ($term) {
                            $q->where(function ($query) use ($term) {
                                $query
                               ->where('users.first_name', 'LIKE', '%'.$term.'%')
                               ->orWhere('users.last_name', 'LIKE', '%'.$term.'%')
                               ->orWhere('user_name', 'LIKE', '%'.$term.'%')
                               ->orWhere('email', 'LIKE', '%'.$term.'%')
                               ->orWhere('organization.address', 'LIKE', '%'.$term.'%')
                                ->orWhere('organization.name', 'LIKE', '%'.$term.'%');
                            });
                        })
                        ->when($user_ids, function ($q) use ($user_ids) {
                            $q->whereIn('users.id', $user_ids);
                        })

                        ->where('is_delete', '!=', 1)
                        ->where('active', '=', 1)
                        ->where('ban', '!=', 1)
                        ->when($term, function ($q) use ($term) {
                            $q->where(function ($query) use ($term) {
                                $query->where('users.first_name', 'LIKE', '%'.$term.'%')
                                ->orWhere('users.last_name', 'LIKE', '%'.$term.'%')
                                ->orWhere('user_name', 'LIKE', '%'.$term.'%')
                                ->orWhere('email', 'LIKE', '%'.$term.'%')
                                ->orWhere('organization.address', 'LIKE', '%'.$term.'%')
                                ->orWhere('organization.name', 'LIKE', '%'.$term.'%');
                            });
                        });

            //Returns all Admins n Agents only
            if ($method == 'agent') {
                $users = $query
                        ->where('users.role', '!=', 'user')
                        ->select('users.id', 'users.email as name', 'users.first_name', 'users.last_name', 'users.profile_pic', 'users.email', 'users.role')
                        ->get();

                // dd($users);
                return $users;
            }
            //Returns all Admins n Agents n Users
            if ($method == 'requester') {
                $users = $query->groupBy('users.id')
                        ->select('users.id', 'users.email as name', 'users.first_name', 'users.last_name', 'users.email', 'users.profile_pic', 'users.role')
                        ->get();

                // dd($users);
                return $users;
            }
            //Returns all Users only
            if ($method == 'user') {
                $users = $query->groupBy('users.id')
                        ->where('users.role', '=', 'user')
                        ->select('users.id', 'users.user_name', 'users.first_name', 'users.last_name', 'users.profile_pic', 'users.email', 'users.role')
                        ->get();

                // dd($users);
                return $users;
            }
            //Returns all Admins only
            if ($method == 'admin') {
                $users = $query->groupBy('users.id')
                        ->where('users.role', '=', 'admin')
                        ->select('users.id', 'users.user_name', 'users.first_name', 'users.last_name', 'users.profile_pic', 'users.email', 'users.role')
                        ->get();

                // dd($users);
                return $users;
            }
            //Returns all Agents only
            if ($method == 'agent-only') {
                $users = $query->groupBy('users.id')
                        ->where('users.role', '=', 'agent')
                        ->select('users.id', 'users.user_name', 'users.first_name', 'users.last_name', 'users.profile_pic', 'users.email', 'users.role')
                        ->get();

                // dd($users);
                return $users;
            }

            //approver
            if ($method == 'approver') {
                $users = $query
                        ->where('users.role', '!=', 'user')
                        ->select('users.id', 'users.email as name', 'users.first_name', 'users.last_name', 'users.profile_pic', 'users.email', 'users.role')
                        ->get()->toArray();

                $default = ['department manager', 'team lead', 'Department manager', 'Team lead'];
                $term = $request->input('term');

                $defaultarray = [];
                foreach ($default as $value) {
                    if (preg_match('/^'.$term.'/', $value)) {
                        array_push($defaultarray, $value);
                    }
                }
                $url = ' ';
                if ((implode(',', $defaultarray) == 'team lead') || (implode(',', $defaultarray) == 'Team lead')) {
                    $url = url('/').'/lb-faveo/media/images/team.jpg';
                }
                if ((implode(',', $defaultarray) == 'department manager') || (implode(',', $defaultarray) == 'Department manager')) {
                    $url = url('/').'/lb-faveo/media/images/department.jpg';
                }
                $extraArray[] = ['id'=>str_slug(implode(',', $defaultarray), '_'), 'name'=>'', 'first_name'=>implode(',', $defaultarray), 'last_name'=>'', 'profile_pic'=>$url, 'email'=>'', 'role'=>''];

                $extraArray = ($url == ' ') ? [] : $extraArray;

                return array_merge($users, $extraArray);
            } else {
                $users = $user->where('user_name', $term)
                        ->where('is_delete', '!=', 1)
                        ->select('id', 'user_name as name', 'first_name', 'last_name', 'role')
                        ->first();

                return $users;
            }
        }
    }
}
