<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\HelptopicRequest;
use App\Http\Requests\HelptopicUpdate;
use App\Model\Agent\Agents;
use App\Model\Agent\Department;
use App\Model\Form\Form_name;
use App\Model\Manage\Help_topic;
use App\Model\Manage\Sla_plan;
use App\Model\Utility\Priority;

/**
 * HelptopicController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class HelptopicController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type vodi
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 * @param type Help_topic $topic
	 * @return type Response
	 */
	public function index(Help_topic $topic) {
		try {
			$topics = $topic->get();
			return view('themes.default1.admin.manage.helptopic.index', compact('topics'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * @param type Priority $priority
	 * @param type Department $department
	 * @param type Help_topic $topic
	 * @param type Form_name $form
	 * @param type Agents $agent
	 * @param type Sla_plan $sla
	 * @return type Response
	 */
	/*
	================================================
	| Route to Create view file passing Model Values
	| 1.Department Model
	| 2.Help_topic Model
	| 3.Agents Model
	| 4.Sla_plan Model
	| 5.Forms Model
	================================================
	 */
	public function create(Priority $priority, Department $department, Help_topic $topic, Form_name $form, Agents $agent, Sla_plan $sla) {
		try {
			$departments = $department->get();
			$topics = $topic->get();
			$forms = $form->get();
			$agents = $agent->get();
			$slas = $sla->get();
			$priority = $priority->get();
			return view('themes.default1.admin.manage.helptopic.create', compact('priority', 'departments', 'topics', 'forms', 'agents', 'slas'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type Help_topic $topic
	 * @param type HelptopicRequest $request
	 * @return type Response
	 */
	public function store(Help_topic $topic, HelptopicRequest $request) {
		try {
			/* Check whether function success or not */
			if ($topic->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('helptopic')->with('success', 'Helptopic Created Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('helptopic')->with('fails', 'Helptopic can not Create');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('helptopic')->with('fails', 'Helptopic can not Create');
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
	 * @param type Priority $priority
	 * @param type Department $department
	 * @param type Help_topic $topic
	 * @param type Form_name $form
	 * @param type Agents $agent
	 * @param type Sla_plan $sla
	 * @return type Response
	 */
	public function edit($id, Priority $priority, Department $department, Help_topic $topic, Form_name $form, Agents $agent, Sla_plan $sla) {
		try {
			$departments = $department->get();
			$topics = $topic->whereId($id)->first();
			$forms = $form->get();
			$agents = $agent->get();
			$slas = $sla->get();
			$priority = $priority->get();
			return view('themes.default1.admin.manage.helptopic.edit', compact('priority', 'departments', 'topics', 'forms', 'agents', 'slas'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * @param type $id
	 * @param type Help_topic $topic
	 * @param type HelptopicUpdate $request
	 * @return type Response
	 */
	public function update($id, Help_topic $topic, HelptopicUpdate $request) {
		try {
			$topics = $topic->whereId($id)->first();
			/* Check whether function success or not */
			if ($topics->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('helptopic')->with('success', 'Helptopic Updated Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('helptopic')->with('fails', 'Helptopic can not Updated');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('helptopic')->with('fails', 'Helptopic can not Create');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @param type Help_topic $topic
	 * @return type Response
	 */
	public function destroy($id, Help_topic $topic) {
		try {
			$topics = $topic->whereId($id)->first();
			/* Check whether function success or not */
			if ($topics->delete() == true) {
				/* redirect to Index page with Success Message */
				return redirect('helptopic')->with('success', 'Helptopic Deleted Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('helptopic')->with('fails', 'Helptopic can not Delete');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('helptopic')->with('fails', 'Helptopic can not Create');
		}
	}
}
