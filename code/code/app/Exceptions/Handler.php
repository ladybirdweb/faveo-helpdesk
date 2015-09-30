<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use App\Http\Controllers\Common\SettingsController;
//use App\Model\helpdesk\Email\Smtp;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Create a new controller instance.
	 * @return type response
	 */
	// public function __construct() {
		// SettingsController::smtp();
	// }

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		// if ($this->isHttpException($e) && $e->getStatusCode() == 404) {
		// 	return response()->view('errors.404', []);
		// } else {
		// 		\App\Http\Controllers\Common\SettingsController::smtp();
		// 			\Mail::send('errors.report', array('e' => $e), function ($message) {
		// 			$message->to('sujitprasad4567@gmail.com', 'Poacher Error')->subject('Error');
		// 		});
		// 	return response()->view('errors.503', []);
		// }	
		return parent::render($request, $e);
	
	}

}
