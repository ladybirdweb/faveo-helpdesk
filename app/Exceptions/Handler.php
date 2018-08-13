<?php

namespace App\Exceptions;

// controller
use Bugsnag;
//use Illuminate\Validation\ValidationException;
use Bugsnag\BugsnagLaravel\BugsnagExceptionHandler as ExceptionHandler;
use Config;
use Exception;
// use Symfony\Component\HttpKernel\Exception\HttpException;
// use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Validation\ValidationException as foundation;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
//        'Symfony\Component\HttpKernel\Exception\HttpException',
        \Illuminate\Http\Exception\HttpResponseException::class,
        foundation::class,
        AuthorizationException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        ValidationException::class,
        \DaveJamesMiller\Breadcrumbs\Exception::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
//        dd($e);
        Bugsnag::setBeforeNotifyFunction(function ($error) { //set bugsnag
            return false;
        });
        // check if system is running in production environment
        if (\App::environment() == 'production') {
            $debug = Config::get('app.bugsnag_reporting'); //get bugsang reporting preference
            if ($debug) { //if preference is true for reporting
                $version = Config::get('app.version'); //set app version in report
                Bugsnag::setAppVersion($version);
                Bugsnag::setBeforeNotifyFunction(function ($error) { //set bugsnag
                    return true;
                }); //set bugsnag reporting as true
            }
        }

        return parent::report($e);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \Illuminate\Validation\ValidationException $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json($exception->errors(), $exception->status);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param type      $request
     * @param Exception $e
     *
     * @return type mixed
     */
    public function render($request, Exception $e)
    {
        switch ($e) {
            case $e instanceof \Illuminate\Http\Exception\HttpResponseException:
                return parent::render($request, $e);
            case $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException:
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getStatusCode()]);
            case $e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException:
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getStatusCode()]);
            case $e instanceof TokenMismatchException:
                if ($request->ajax() || $request->wantsJson()) {
                    $result = ['fails' => \Lang::get('lang.session-expired')];

                    return response()->json(compact('result'), 402);
                }

                return redirect()->back()->with('fails', \Lang::get('lang.session-expired'));
            default:
                return $this->common($request, $e);
        }
    }

    /**
     * Function to render 500 error page.
     *
     * @param type $request
     * @param type $e
     *
     * @return type mixed
     */
    public function render500($request, $e)
    {
        if (config('app.debug') == true) {
            return parent::render($request, $e);
        } elseif ($e instanceof foundation) {
            return parent::render($request, $e);
        } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
            return parent::render($request, $e);
        }

        return response()->view('errors.500');
        //return redirect()->route('error500', []);
    }

    /**
     * Function to render 404 error page.
     *
     * @param type $request
     * @param type $e
     *
     * @return type mixed
     */
    public function render404($request, $e)
    {
        $seg = $request->segments();
        if (in_array('api', $seg)) {
            return response()->json(['success' => false, 'message' => trans('lang.invalid_attempt')], 404);
        }
        if (config('app.debug') == true) {
            if ($e->getStatusCode() == '404') {
                return redirect()->route('error404', []);
            }

            return parent::render($request, $e);
        }

        return redirect()->route('error404', []);
    }

    /**
     * Function to render database connection failed.
     *
     * @param type $request
     * @param type $e
     *
     * @return type mixed
     */
    public function renderDB($request, $e)
    {
        $seg = $request->segments();
        if (in_array('api', $seg)) {
            return response()->json(['status' => '404']);
        }
        if (config('app.debug') == true) {
            return parent::render($request, $e);
        }

        return redirect()->route('error404', []);
    }

    /**
     * Common finction to render both types of codes.
     *
     * @param type $request
     * @param type $e
     *
     * @return type mixed
     */
    public function common($request, $e)
    {
        switch ($e) {
            case $e instanceof HttpException:
                return $this->render404($request, $e);
            case $e instanceof NotFoundHttpException:
                return $this->render404($request, $e);
            case $e instanceof PDOException:
                if (strpos('1045', $e->getMessage()) == true) {
                    return $this->renderDB($request, $e);
                } else {
                    return $this->render500($request, $e);
                }
//            case $e instanceof ErrorException:
//                if($e->getMessage() == 'Breadcrumb not found with name "" ') {
//                    return $this->render404($request, $e);
//                } else {
//                    return parent::render($request, $e);
//                }
            case $e instanceof TokenMismatchException:
                if ($request->ajax() || $request->wantsJson()) {
                    $result = ['fails' => \Lang::get('lang.session-expired')];

                    return response()->json(compact('result'), 402);
                }

                return redirect()->back()->with('fails', \Lang::get('lang.session-expired'));
            case $e instanceof AuthorizationException:
                return redirect('/')->with('fails', \Lang::get('lang.access-denied'));
            case $e instanceof MethodNotAllowedHttpException:
                if (stripos($request->url(), 'api')) {
                    $result = ['message' => \Lang::get('lang.methon_not_allowed'), 'success' => false];

                    return response()->json($result, 405);
                }
                $this->render500($request, $e);
            default:
                return $this->render500($request, $e);
        }

        return parent::render($request, $e);
    }
}
