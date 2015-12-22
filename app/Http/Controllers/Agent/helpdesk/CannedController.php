<?php namespace App\Http\Controllers\Agent\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\CannedRequest;
use App\Http\Requests\helpdesk\CannedUpdateRequest;
// model
use App\Model\helpdesk\Agent_panel\Canned;
use App\User;

/**
 * UserController
 *
 * @package   Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class CannedController extends Controller {

	/**
	 * Create a new controller instance.
	 * constructor to check
	 * 1. authentication
	 * 2. user roles
	 * 3. roles must be agent
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('role.agent');
		// $this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 * @param type User $user
	 * @return type Response
	 */
	public function index() {
		return view('themes.default1.agent.helpdesk.canned.index');
	}

	/**
	 * Show the form for creating a new resource.
	 * @return type Response
	 */
	public function create() {
		return view('themes.default1.agent.helpdesk.canned.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * @param type User $user
	 * @param type Sys_userRequest $request
	 * @return type Response
	 */
	public function store(CannedRequest $request, Canned $canned) {
		$canned->user_id = \Auth::user()->id;
		$canned->title = $request->input('title');
		$canned->message = $request->input('message');
		$canned->save();
		return redirect()->route('canned.list')->with('success','Added Successfully');
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param type int $id
	 * @param type User $user
	 * @return type Response
	 */
	public function edit($id, Canned $canned) {
		$canned = $canned->where('user_id', '=', \Auth::user()->id)->where('id','=',$id)->first();
		return view('themes.default1.agent.helpdesk.canned.edit',compact('canned'));
	}

	/**
	 * Update the specified resource in storage.
	 * @param type int $id
	 * @param type User $user
	 * @param type Sys_userUpdate $request
	 * @return type Response
	 */
	public function update($id, CannedUpdateRequest $request, Canned $canned) {

		$canned = $canned->where('id','=',$id)->where('user_id', '=', \Auth::user()->id)->first();
		$canned->user_id = \Auth::user()->id;
		$canned->title = $request->input('title');
		$canned->message = $request->input('message');
		$canned->save();

		return redirect()->route('canned.list')->with('success','Updated Successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 * @param type int $id
	 * @param type User $user
	 * @return type Response
	 */
	public function destroy($id, Canned $canned) {
		/* select the field where id = $id(request Id) */
			$canned = $canned->whereId($id)->first();
			/* delete the selected field */
			/* Check whether function success or not */
			if ($canned->delete() == true) {
				/* redirect to Index page with Success Message */
				return redirect()->route('canned.list')->with('success', 'User  Deleted Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect()->route('canned.list')->with('fails', 'User  can not Delete');
			}
		return view('themes.default1.agent.helpdesk.canned.destroy');
	}

	/**
	 * get canned
	 * @param type $id 
	 * @return type json
	 */
	public function get_canned($id) {
		if($id != "zzz") {
			$canned = Canned::where('id','=',$id)->where('user_id','=',\Auth::user()->id)->first();
			$msg = $canned->message;	
		} else {
			$msg = "";	
		}
		return \Response::json($msg);
	}

}