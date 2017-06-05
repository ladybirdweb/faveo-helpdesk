<?php

namespace App\Http\Controllers\Utility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Custom\Form;
use DB;

class FormController extends Controller {

    public function getTicketFormJson() {
        $form = new Form();
        $custom = $form->where('form', 'ticket')->select('json')->first();
        $json = "";
        if ($custom) {
            $json = str_replace("'", '"', $custom->json);
        }
        return '[' . $json . "]";
    }

    public function dependancy(Request $request) {
        $dependency = $request->input('dependency', 'priority');
        return $this->getDependancy($dependency);
    }

    public function getDependancy($dependency) {
        switch ($dependency) {
            case "priority":
                return DB::table('ticket_priority')->select('priority_id as id', 'priority as optionvalue')->get()->toJson();
            case "department":
                return DB::table('department')->select('id', 'name as optionvalue')->get()->toJson();
            case "type":
                return DB::table('ticket_type')->select('id', 'name as optionvalue')->get()->toJson();
            case "assigned_to":
                return DB::table('users')->where('role', '!=', 'user')->select('id', 'user_name as optionvalue')->get()->toJson();
            case "company":
                return DB::table('organization')->select('id', 'name as optionvalue')->get()->toJson();
            case "status":
                return DB::table('ticket_status')->select('id', 'name as optionvalue')->get()->toJson();
            case "helptopic":
                return DB::table('help_topic')->select('id', 'topic as optionvalue')->get()->toJson();
        }
    }

    public function requester(Request $request) {
        $user = new \App\User();
        $term = $request->input('term');
        $users = $user
                ->where('first_name','LIKE','%'.$term.'%')
                ->orWhere('last_name','LIKE','%'.$term.'%')
                ->orWhere('user_name','LIKE','%'.$term.'%')
                ->orWhere('email','LIKE','%'.$term.'%')
                ->with(['org' => function($org) {
                        $org->select('org_id', 'user_id');
                    }, 'org.organisation' => function($company) {
                        $company->select('id', 'name as company');
                    }])
                ->select('id', 'user_name as name','first_name','last_name')
                ->get();
        return $users;
    }
    
    public function authRequesterClient(){
        $user = NULL;
        if(\Auth::user()){
            $user = \Auth::user();
                
        }
        return $user;
    }

}
