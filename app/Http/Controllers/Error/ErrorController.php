<?php
namespace App\Http\Controllers\Error;
use App\Http\Controllers\Controller;

/**
 * ErrorController
 *
 * @package 	Controllers
 * @subpackage 	Controller
 * @author     	Ladybird <info@ladybirdweb.com>
 */
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
