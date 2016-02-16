<?php

namespace App\Exceptions;

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

        if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['message' => $e->getMessage(), 'code' => $e->getStatusCode()]);
            //dd($e);
        } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['message' => $e->getMessage(), 'code' => $e->getStatusCode()]);
        }

        // if (config('app.debug') == false) {
        //     if ($this->isHttpException($e) && $e->getStatusCode() == 404) {
        //         return response()->view('errors.404', []);
        //     } else {
        //         if (\Config::get('database.install') == 1) {
        //             // if(\Config::get('app.ErrorLog') == '%1%') {
        //             // 	\App\Http\Controllers\Common\SettingsController::smtp();
        //             //    $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => '', 'email' => ''], $message = ['subject' => '', 'scenario'=>'error-report'], $template_variables = ['e' =>$e ]);
        //             // }
        //         }
        //         return response()->view('errors.500', []);
        //     }
        // }
        // return parent::render($request, $e);

        if ($this->isHttpException($e)) {
            return $this->renderHttpException($e);
        }

        if (config('app.debug')) {
            return $this->renderExceptionWithWhoops($e);
        }

        return parent::render($request, $e);
    }

    protected function renderExceptionWithWhoops(Exception $e) {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new \Illuminate\Http\Response(
                $whoops->handleException($e), $e->getStatusCode(), $e->getHeaders()
        );
    }

}
