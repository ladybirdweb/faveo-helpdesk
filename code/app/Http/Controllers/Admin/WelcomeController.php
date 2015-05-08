<?php

namespace App\Http\Controllers\Admin;

/**
 * --------------------------------------------
 * WelcomeController
 * --------------------------------------------
 * This controller renders the "marketing page" for the application and
 * is configured to only allow guests. Like most of the other sample
 * controllers, you are free to modify or remove it as you desire.
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class WelcomeController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index() {
		return view('welcome');
	}

}
