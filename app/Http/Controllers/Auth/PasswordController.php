<?php namespace App\Http\Controllers\Auth;
// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\SettingsController;

// request
use Illuminate\Http\Request;

// model
use App\User;

// classes
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

/**
 * PasswordController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class PasswordController extends Controller {

	use ResetsPasswords;

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords) {
		$this->auth = $auth;
		$this->passwords = $passwords;
		$this->middleware('guest');
		SettingsController::smtp();
	}


	/**
	 * Display the form to request a password reset link.
	 *
	 * @return Response
	 */
	public function getEmail() {
		return view('auth.password');
	}


}
