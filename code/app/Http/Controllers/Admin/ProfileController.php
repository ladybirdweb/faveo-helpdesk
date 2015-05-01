<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilePassword;

/*  include guest_note model */
use App\Http\Requests\ProfileRequest;

/* include User Model */
/* include Help_topic Model */

/* Profile validator */
use App\User;

/* Profile Password validator */

/* include ticket_thred model */
use Auth;

/* include tickets model */

/* TicketRequest to validate the ticket response */
use Hash;

/* Validate post check ticket */

use Input;

class ProfileController extends Controller {

	/* Define constructor for Authentication Checking */

	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
	}

	public function getProfile() {
		try
		{
			$user = Auth::user();
			if ($user) {
				return view('themes.default1.admin.profile', compact('user'));
			} else {
				return redirect('404');
			}
		} catch (Exception $e) {
			return redirect('404');
		}
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

	public function postProfilePassword($id, User $user, ProfilePassword $request) {
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
