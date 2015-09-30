<?php namespace App\Http\Controllers\Admin\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\ProfilePassword;
use App\Http\Requests\ProfileRequest;
// models
use App\User;
// classes
use Auth;
use Hash;
use Input;

/**
 * ProfileController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class ProfileController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * Get profile page
	 * @return type Response
	 */
	public function getProfile() {
		try {
			$user = Auth::user();
			if ($user) {
				return view('themes.default1.agent.helpdesk.user.profile', compact('user'));
			} else {
				return redirect('404');
			}
		} catch (Exception $e) {
			return redirect('404');
		}
	}

	/**
	 * Get profile Edit page
	 * @return type Response
	 */
	public function getProfileedit() {
		try {
			$user = Auth::user();
			if ($user) {
				return view('themes.default1.agent.helpdesk.user.profile-edit', compact('user'));
			} else {
				return redirect('404');
			}
		} catch (Exception $e) {
			return redirect('404');
		}
	}

	/**
	 * Post profile page
	 * @param type int $id
	 * @param type ProfileRequest $request
	 * @return type Response
	 */
	public function postProfile($id, ProfileRequest $request) {
		$user = Auth::user();
		$user->gender = $request->input('gender');
		$user->save();
		if ($user->profile_pic == 'avatar5.png' || $user->profile_pic == 'avatar2.png') {
			if ($request->input('gender') == 1) {
				$name = 'avatar5.png';
				$destinationPath = 'lb-faveo/profilepic';
				$user->profile_pic = $name;
			} elseif ($request->input('gender') == 0) {
				$name = 'avatar2.png';
				$destinationPath = 'lb-faveo/profilepic';
				$user->profile_pic = $name;
			}
		}
		if (Input::file('profile_pic')) {
			//$extension = Input::file('profile_pic')->getClientOriginalExtension();
			$name = Input::file('profile_pic')->getClientOriginalName();
			$destinationPath = 'lb-faveo/profilepic';
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

	/**
	 * Post  Profile password page
	 * @param type int $id
	 * @param type User $user
	 * @param type ProfilePassword $request
	 * @return type Response
	 */
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
