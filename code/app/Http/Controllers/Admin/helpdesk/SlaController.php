<?php namespace App\Http\Controllers\Admin\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\SlaRequest;
use App\Http\Requests\helpdesk\SlaUpdate;
// models
use App\Model\helpdesk\Manage\Sla_plan;

/**
 * SlaController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class SlaController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 * @param type Sla_plan $sla
	 * @return type Response
	 */
	public function index(Sla_plan $sla) {
		try {
			/* Declare a Variable $slas to store all Values From Sla_plan Table */
			$slas = $sla->get();
			/* Listing the values From Sla_plan Table */
			return view('themes.default1.admin.helpdesk.manage.sla.index', compact('slas'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * @return type Response
	 */
	public function create() {
		try {
			/* Direct to Create Page */
			return view('themes.default1.admin.helpdesk.manage.sla.create');
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type Sla_plan $sla
	 * @param type SlaRequest $request
	 * @return type Response
	 */
	public function store(Sla_plan $sla, SlaRequest $request) {
		try {
			/* Fill the request values to Sla_plan Table  */
			/* Check whether function success or not */
			if ($sla->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('sla')->with('success', 'SLA Plan Created Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('sla')->with('fails', 'SLA Plan can not Create');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('sla')->with('fails', 'SLA Plan can not Create');
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
	 * @param type Sla_plan $sla
	 * @return type Response
	 */
	public function edit($id, Sla_plan $sla) {
		try {
			/* Direct to edit page along values of perticular field using Id */
			$slas = $sla->whereId($id)->first();
			$slas->get();
			return view('themes.default1.admin.helpdesk.manage.sla.edit', compact('slas'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Update the specified resource in storage.
	 * @param type int $id
	 * @param type Sla_plan $sla
	 * @param type SlaUpdate $request
	 * @return type Response
	 */
	public function update($id, Sla_plan $sla, SlaUpdate $request) {
		try {
			/* Fill values to selected field using Id except Check box */
			$slas = $sla->whereId($id)->first();
			$slas->fill($request->except('transient', 'ticket_overdue'))->save();
			/* Update transient checkox field */
			$slas->transient = $request->input('transient');
			/* Update ticket_overdue checkox field */
			$slas->ticket_overdue = $request->input('ticket_overdue');
			/* Check whether function success or not */
			if ($slas->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('sla')->with('success', 'SLA Plan Updated Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('sla')->with('fails', 'SLA Plan can not Update');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('sla')->with('fails', 'SLA Plan can not Update');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @param type Sla_plan $sla
	 * @return type Response
	 */
	public function destroy($id, Sla_plan $sla) {
		try {
			/* Delete a perticular field from the database by delete() using Id */
			$slas = $sla->whereId($id)->first();
			/* Check whether function success or not */
			if ($slas->delete() == true) {
				/* redirect to Index page with Success Message */
				return redirect('sla')->with('success', 'SLA Plan Deleted Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('sla')->with('fails', 'SLA Plan can not Delete');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('sla')->with('fails', 'SLA Plan can not Delete');
		}
	}

}
