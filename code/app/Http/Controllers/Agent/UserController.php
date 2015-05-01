<?php namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;

/*  Include Sys_user Model  */
use App\Http\Requests\ProfilePassword;

/* For validation include Sys_userRequest in create  */
use App\Http\Requests\ProfileRequest;

/* For validation include Sys_userUpdate in update  */
use App\Http\Requests\Sys_userRequest;

/*  include guest_note model */
use App\Http\Requests\Sys_userUpdate;

/* include User Model */
use App\Model\Agent_panel\Sys_user;
/* include Help_topic Model */

/* Profile validator */

/* Profile Password validator */
use App\User;

/* include ticket_thred model */
use Auth;

/* include tickets model */
use Hash;

/* TicketRequest to validate the ticket response */

/* Validate post check ticket */
use Input;

class UserController extends Controller {

	/* Define constructor for Authentication Checking */

	public function __construct() {
		$this->middleware('auth');
		$this->middleware('role.agent');
		$this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Sys_user $user) {
		try
		{
			/* get all values in Sys_user */
			$users = $user->get();

			return view('themes.default1.agent.user.index', compact('users'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		try
		{
			return view('themes.default1.agent.user.create');
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Sys_user $user, Sys_userRequest $request) {
		try
		{
			/* insert the input request to sys_user table */

			/* Check whether function success or not */

			if ($user->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('user')->with('success', 'User  Created Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('user')->with('fails', 'User  can not Create');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('user')->with('fails', 'User  can not Create');
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Sys_user $user) {
		try
		{
			/* select the field where id = $id(request Id) */
			$users = $user->whereId($id)->first();

			return view('themes.default1.agent.user.show', compact('users'));
		} catch (Exception $e) {
			return view('404');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Sys_user $user) {
		try
		{
			/* select the field where id = $id(request Id) */
			$users = $user->whereId($id)->first();

			return view('themes.default1.agent.user.edit', compact('users'));
		} catch (Exception $e) {
			return view('404');
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Sys_user $user, Sys_userUpdate $request) {
		try
		{
			/* select the field where id = $id(request Id) */
			$users = $user->whereId($id)->first();

			/* Update the value by selected field  */
			/* Check whether function success or not */

			if ($users->fill($request->input())->save() == true) {
				/* redirect to Index page with Success Message */
				return redirect('user')->with('success', 'User  Updated Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('user')->with('fails', 'User  can not Update');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('user')->with('fails', 'User  can not Update');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Sys_user $user) {
		try
		{
			/* select the field where id = $id(request Id) */
			$users = $user->whereId($id)->first();

			/* delete the selected field */
			/* Check whether function success or not */

			if ($users->delete() == true) {
				/* redirect to Index page with Success Message */
				return redirect('user')->with('success', 'User  Deleted Successfully');
			} else {
				/* redirect to Index page with Fails Message */
				return redirect('user')->with('fails', 'User  can not Delete');
			}
		} catch (Exception $e) {
			/* redirect to Index page with Fails Message */
			return redirect('user')->with('fails', 'User  can not Delete');
		}
	}
	public function getProfile() {
		$user = Auth::user();
		return view('themes.default1.agent.user.profile', compact('user'));
	}

	public function postProfile($id, ProfileRequest $request) {
		$user = Auth::user();
		$user->gender = $request->input('gender');
		$user->save();

		if ($user->profile_pic == 'avatar5.png' || $user->profile_pic == 'avatar2.png') {
			if ($request->input('gender') == 1) {

				$name = 'avatar5.png';
				$destinationPath = 'dist/img';
				$user->profile_pic = $name;
			} elseif ($request->input('gender') == 0) {

				$name = 'avatar2.png';
				$destinationPath = 'dist/img';
				$user->profile_pic = $name;
			}
		}

		if (Input::file('profile_pic')) {
			//$extension = Input::file('profile_pic')->getClientOriginalExtension();
			$name = Input::file('profile_pic')->getClientOriginalName();

			$destinationPath = 'dist/img';
			$fileName = rand(0000, 9999) . '.' . $name;
			//echo $fileName;

			Input::file('profile_pic')->move($destinationPath, $fileName);

			$user->profile_pic = $fileName;

		} else {
			$user->fill($request->except('profile_pic', 'gender'))->save();
			return redirect('guest')->with('success', 'Profile Updated sucessfully');

		}

		if ($user->fill($request->except('profile_pic'))->save()) {
			return redirect('guest')->with('success', 'Profile Updated sucessfully');
		}
	}

	public function postProfilePassword($id, ProfilePassword $request) {
		$user = Auth::user();
		//echo $user->password;

		if (Hash::check($request->input('old_password'), $user->getAuthPassword())) {
			$user->password = Hash::make($request->input('new_password'));
			$user->save();
			return redirect('guest')->with('success', 'Password Updated sucessfully');
		} else {
			return redirect('guest')->with('fails', 'Password was not Updated');
		}
	}

}
