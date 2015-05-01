<?php namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;

class ErrorController extends Controller {

	/**
	 * Display a Error Page of 404.
	 *
	 * @return Response
	 */
	public function error404() {
		return view('404');
	}

}
