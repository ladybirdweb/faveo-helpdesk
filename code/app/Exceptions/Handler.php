<?php namespace App\Exceptions;

use Exception;
// use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Bugsnag\BugsnagLaravel\BugsnagExceptionHandler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException',
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e) {
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e) {
		if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
			return redirect('404');
		} elseif ($e instanceof \Illuminate\View\Engines\handleViewException) {
			return redirect('404');
		} elseif ($e instanceof \Illuminate\Database\QueryException) {
			return redirect('404');
		} elseif ($e) {
			return redirect('404');
		}
		return parent::render($request, $e);
	}

}
