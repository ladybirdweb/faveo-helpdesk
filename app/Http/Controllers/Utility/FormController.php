<?php

namespace App\Http\Controllers\Utility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Custom\Form;
use DB;
use Auth;
use Input;

class FormController extends Controller
{
    /**
     * get the form in json format
     * @param boolean $array
     * @return array|json
     */
    public function getTicketFormJson($form_type = "ticket", $array = false)
    {
        $form   = new Form();
        $custom = $form->where('form', $form_type)->select('json')->first();
        $json   = "";
        if ($custom) {
            $json = str_replace("'", '"', $custom->json);
        }
        $json_event = checkArray('0',event(new \App\Events\ClientTicketForm($json)));
        if ($json_event) {
            $json = json_encode($json_event);
        }
        if ($array) {
            return $json;
        }
        return '[' . $json . ']';
    }
    /**
     * get all dependencies
     * @param Request $request
     * @return mixed
     */
    public function dependancy(Request $request)
    {
        $linked_topic = ($request->has('linkedtopic')) ? $request->get('linkedtopic')
                    : '';
        $dependency   = $request->input('dependency', 'priority');
        return $this->getDependancy($dependency, $linked_topic);
    }
    /**
     * get the model for every dependency
     * @param string $dependency
     * @return mixed
     */
    public function getDependancy($dependency, $linked_topic = '')
    {
        // dd($dependency);
        switch ($dependency) {
            case "priority":
                $auth_user = \Auth::user();
                if ($auth_user && $auth_user->role != 'user') {
                    return DB::table('ticket_priority')->where('status', '=', 1)->select('priority_id as id', 'priority as optionvalue')->get()->toJson();
                }
                else {
                    return DB::table('ticket_priority')->where('status', '=', 1)->where('ispublic', 1)->select('priority_id as id', 'priority as optionvalue')->get()->toJson();
                }
            case "department":
                $departments = DB::table('department')->select('id', 'name as optionvalue', 'nodes');
                if ($linked_topic != '') {
                    $help_topic = DB::table('help_topic')->select('linked_departments', 'department')->where('id', '=', $linked_topic)->first();
                    if ($help_topic->linked_departments == null || $help_topic->linked_departments
                            == '') {
                        $departments = $departments->where('id', '=', $help_topic->department)->get();
                    }
                    else {
                        $dept_ids    = explode(",", $help_topic->linked_departments);
                        $departments = $departments->whereIn('id', $dept_ids)->get();
                    }
                    // ->get();
                }
                else {
                    $departments = $departments->get();
                }
                foreach ($departments as $value) {
                    $value->optionvalue = [['language' => 'en', 'option' => $value->optionvalue, 'flag' => asset("lb-faveo/flags/en.png")]];
                    if ($value->nodes != null) {
                        $value->nodes = json_decode(str_replace("'", '"', $value->nodes));
                    }
                    else {
                        $value->nodes = [];
                    }
                }
                return response()->json($departments);
            case "faveo_department":
                return DB::table('department')->select('id', 'name as optionvalue')->get()->toJson();
            case "type":
                $auth_user = \Auth::user();
                if ($auth_user && $auth_user->role != 'user') {

                    return DB::table('ticket_type')->where('status', '=', 1)->select('id', 'name as optionvalue')->get()->toJson();
                }
                else {
                    return DB::table('ticket_type')->where('status', '=', 1)->where('ispublic', '=', 1)->select('id', 'name as optionvalue')->get()->toJson();
                }
            case "assigned_to":
                return DB::table('users')->where('role', '!=', 'user')->where('is_delete', '!=', 1)->where('ban', '!=', 1)->select('id', 'user_name as optionvalue')->get()->toJson();
            case "company":
                return DB::table('organization')->select('id', 'name as optionvalue')->get()->toJson();
            case "status":
                if (Auth::user() && Auth::user()->role != 'user') {
                    return DB::table('ticket_status')->select('id', 'name as optionvalue')->get()->toJson();
                }
                return DB::table('ticket_status')->where('visibility_for_client', 1)->where('allow_client', 1)->select('id', 'name as optionvalue')->where('purpose_of_status', 1)->get()->toJson();
            case "help_topic":
                $auth_user = \Auth::user();
                if ($auth_user && $auth_user->role != 'user') {
                    $help_topics = DB::table('help_topic')->where('status', '=', 1)->select('id', 'topic as optionvalue', 'nodes')->get()->toJson();
                }
                else {
                    $help_topics = DB::table('help_topic')->where('status', '=', 1)->where('type', '=', 1)->select('id', 'topic as optionvalue', 'nodes')->get()->toJson();
                }
                return $help_topics;
            // case "status":
            //     return DB::table('ticket_status')->select('id', 'name as optionvalue')->get()->toJson();
            case "helptopic":

                $auth_user = \Auth::user();
                if ($auth_user && $auth_user->role != 'user') {
                    $help_topics = DB::table('help_topic')->where('status', '=', 1)->select('id', 'topic as optionvalue', 'nodes')->get();
                }
                else {
                    $help_topics = DB::table('help_topic')->where('status', '=', 1)->where('type', '=', 1)->select('id', 'topic as optionvalue', 'nodes')->get();
                }
                foreach ($help_topics as $value) {
                    $value->optionvalue = [['language' => 'en', 'option' => $value->optionvalue, 'flag' => asset("lb-faveo/flags/en.png")]];
                    if ($value->nodes != null) {
                        $value->nodes = json_decode(str_replace("'", '"', $value->nodes));
                    }
                    else {
                        $value->nodes = [];
                    }
                }
                return response()->json($help_topics);
            case "source":
                return DB::table('ticket_source')->select('id', 'value as optionvalue')->get()->toJson();
            case "location":
                // return DB::table('location')->select('title', 'title as optionvalue')->get()->toJson();
                $auth_user = \Auth::user();
                if ($auth_user && $auth_user->role != 'user') {


                    if (\Auth::user()->role === 'admin') {
                        return DB::table('location')->select('title as id', 'title as optionvalue')->get()->toJson();
                    }
                    else {
                        $agent_location = User::where('id', '=', \Auth::user()->id)->select('location')->first();
                        return DB::table('location')->where('id', '=', $agent_location->location)->select('title as id', 'title as optionvalue')->get()->toJson();
                    }
                }
                else {
                    return DB::table('location')->select('title as id', 'title as optionvalue')->get()->toJson();
                }


//            case "organisationdept":
//                $company[] = Input::get('company');
////          dd($company);
//                if ($company[0] != null) {
//                    $auth_user = \Auth::user();
//                    if ($auth_user && $auth_user->role != 'user') {
//                        $company = Input::get('company');
////                       
//                        $company_array=explode(",",$company);
////                        $company_array=$comany_array->toArray();
//                       
//                        $orgs_depts= DB::table('organization')->whereIn('id', $company_array)->pluck('department')->toArray();
////                     dd($orgs_depts);
//                        if ($orgs_depts) {
//                            foreach ($orgs_depts as $orgs_dept) {
//                                if($orgs_dept!=""){
//                                $orgs[] = explode(",", $orgs_dept);
//                                }
//                            }
//                            $formatted_orgs1 = array_reduce($orgs, 'array_merge', array());
//                            $allowed = [""];
//                            $formatted_orgs = array_diff($formatted_orgs1, $allowed);
//                           
//                            foreach ($formatted_orgs as $key => $value) {
//
//                                $formatted_orgs_dept[] = ['id' => $key, 'optionvalue' => $value];
//                            }
////                return \Response::json($formatted_orgs_dept);
//                        }
//                        return\Response::json($formatted_orgs_dept);
//                    } else {
//
//                        return \Response::json();
//                    }
////                    dd($formatted_orgs);
//                }
        }
    }
    /**
     * get requester in form
     * @param Request $request
     * @return json
     */
    public function requester(Request $request)
    {
        $method   = $request->input('type', 'agent');
        $user_ids = explode(',', $request->input('user_id', ''));
        $user     = new \App\User();
        $term     = $request->input('term');
        if ($method == 'agent') {
            $users = $user
                    ->when($user_ids, function($q)use($user_ids) {
                        $q->whereIn('id', $user_ids);
                    })
                    ->where('is_delete', '!=', 1)
                    ->when($term, function($q) use($term) {
                        $q->where('first_name', 'LIKE', '%' . $term . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $term . '%')
                        ->orWhere('user_name', 'LIKE', '%' . $term . '%')
                        ->orWhere('email', 'LIKE', '%' . $term . '%');
                    })
                    ->with(['org' => function($org) {
                            $org->select('org_id', 'user_id');
                        }, 'org.organisation' => function($company) {
                            $company->select('id', 'name as company');
                        }])
                    ->select('id', 'user_name as name', 'first_name', 'last_name')
                    ->get();
            return $users;
        }
        else {
            $users = $user->where('user_name', $term)
                    ->where('is_delete', '!=', 1)
                    ->select('id', 'user_name as name', 'first_name', 'last_name')
                    ->first();
            return $users;
        }
    }
    /**
     * get the authentcated user deatails in client page
     * @return json
     */
    public function authRequesterClient()
    {
        $user = NULL;
        if (\Auth::user()) {
            $user = \Auth::user();
        }
        return $user;
    }
    /**
     * parse the form from json to array
     * @return array
     */
    public function ticketFormBuilder($form)
    {
        $json            = $this->getTicketFormJson($form, true);
        $array           = json_decode($json, true);
        $array_title_key = collect($array)->keyBy('unique')->toArray();
        $result          = $this->parseTicketFormArray($array_title_key);
        return $result;
    }
    /**
     * get values in array after
     * @param array $array
     * @return array
     */
    public function parseTicketFormArray($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[$key] = $this->parseParent($value, $key);
        }
        return $result;
    }
    /**
     * parse the parent field is it is a nested field
     * @param array $value
     * @param string $key
     * @param string $parent
     * @param string $child
     * @param string $option_value
     * @return array
     */
    public function parseParent($value, $key = "", $parent = "", $child = "", $option_value
    = "")
    {
        //dd($value);
        $agent       = checkArray('agentRequiredFormSubmit', $value);
        $client      = checkArray('customerRequiredFormSubmit', $value);
        $label       = checkArray('agentlabel', $value);
        $agent_label = "";
        if ($label && is_array($label)) {
            $agent_label = head($label)['label'];
        }
        if(is_string($label)){
            $agent_label = $label;
        }
        $result['agent_label'] = $agent_label;
        $result['agent']       = $agent;
        $result['client']      = $client;
        $result['parent']      = $parent;
        $result['label']       = $child;
        $result['option']      = $option_value;
        $options               = checkArray('options', $value);
        if ($options && count($options) > 0) {
            $array = $this->parseOptions($options, $key);
            if (is_array($array)) {
                $result = array_merge($result, $array);
            }
        }
        return $result;
    }
    /**
     * 
     * @param array $options
     * @param string $parent
     * @return type
     */
    public function parseOptions($options, $parent = "")
    {
        $result = [];
        foreach ($options as $option) {
            $nodes        = checkArray('nodes', $option);
            $option_value = checkArray('optionvalue', $option);
            if ($nodes && checkArray('0', $nodes)) {
                $node                             = $nodes[0];
                $result['child'][$node['unique']] = $this->parseParent($node, $node['agentlabel'], $parent, $node['agentlabel'], $option_value);
            }
        }
        return $result;
    }
    public function saveRequired($form = 'ticket')
    {
        \App\Model\Custom\Required::
                where('form', $form)
                ->delete();
        $array = $this->ticketFormBuilder($form);
        foreach ($array as $parent => $values) {
            $this->saveOptions($parent, $values, $form);
        }
    }
    public function saveOptions($key, $values, $form, $option = 'required', $parent_id
    = "")
    {
        $required     = [];
        $child        = checkArray('child', $values);
        $option_value = checkArray('option', $values);
        if (!is_string($option_value)) {
            $option_value = head($option_value)['option'];
        }
        $required['option'] = $option_value;
        if (checkArray('agent', $values)) {
            $required['agent'] = $option;
        }
        if (checkArray('client', $values)) {
            $required['client'] = $option;
        }
        if ($parent_id) {
            $required['parent'] = $parent_id;
        }
        if ($required) {

            if (!is_string($key)) {
                $key = head($key)['label'];
            }
            $required['field'] = $key;
            $required['form']  = $form;
            $required['label'] = checkArray('agent_label', $values);
            $required_model    = \App\Model\Custom\Required::updateOrCreate($required);
            if ($child) {
                $parent_field_name = $key;
                $this->saveChild($child, $parent_field_name, $required_model, $form);
            }
        }
    }
    public function saveChild($child, $parent_field_name, $model, $form, $option_value
    = "")
    {
        foreach ($child as $key => $values) {
            $option = "required_if:$parent_field_name";
            $this->saveOptions($key, $values, $form, $option, $model->id);
        }
    }
}