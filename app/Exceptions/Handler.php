<?php

namespace App\Exceptions;

use Bugsnag;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Validation\ValidationException;
use PDOException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        // Handle route model binding failure
        $this->handleModelNotFoundException($exception);

        // Handle database connection failed
        $this->reportDatabaseConnectionFailed($exception);

        parent::report($exception);

        // Send unhandled exceptions to bugsnag
        $this->reportToBugsnag($exception);
    }

    /**
     * Function to handle ModelNotFoundException exception thrown while binding
     * route with models.
     *
     * @param \Exception $exception
     *
     * @throws NotFoundHttpException
     *
     * @return void
     */
    public function handleModelNotFoundException(Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            throw new NotFoundHttpException(trans('lang.not_found'));
        }
    }

    /**
     * Function to check the exception should be stored in database exception logs
     * or not.
     *
     * @param Exception $exception current Exception instance
     *
     * @return bool false if exception should not be logged in DB, otherwise true
     */
    private function shouldBeLoggedInDB(Exception $exception)
    {
        $notAllowedExceptions = [PDOException::class, MaintenanceModeException::class, NotFoundHttpException::class];
        foreach ($notAllowedExceptions as $notAllowedException) {
            if ($exception instanceof $notAllowedException) {
                return false;
            }
        }

        return true;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse |
     *                                   Illuminate\Http\RedirectResponse
     */
    public function render($request, Exception $exception)
    {
        // Handle for APIs
        if (stripos($request->url(), 'api') || $request->ajax() || $request->wantsJson()) {
            return $this->responseForApi($request, $exception);
        }

        //if validation exception then let parent class render it
        if ($exception instanceof ValidationException) {
            return parent::render($request, $exception);
        }

        //if model/HTTP not found error show custom 404 irrespective of app debug mode
        if ($exception instanceof NotFoundHttpException) {
            return redirect('404');
        }

        //else render exception based on debug mode
        return $this->renderExceptionBasedOnDebugMode($request, $exception);
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
        return response()->json($exception->errors(), FAVEO_VALIDATION_ERROR_CODE);
    }

    /**
     * Report to Bugsnag.
     *
     * @param Exception $exception Exception instance
     *
     * @return void
     */
    protected function reportToBugsnag(Exception $exception)
    {
        // Check bugsnag reporting is active
        if (config('app.bugsnag_reporting') && $this->shouldNotifyToBugSnag($exception)) {
            Bugsnag::notifyException($exception);
        }
    }

    /**
     * Function to decide whether the exception should be notified to Bugsnag
     * or not. The intent of this method is to skip Bugsnag reporting for general
     * exceptions like ValidationExeption, AuthenticationException etc. to avoid
     * high usage of Bugsnag allowd events.
     *
     * NOTE: There is an issue with bugsnag reporting to skip reporting for $dontReport
     * refrence https://laracasts.com/discuss/channels/laravel/validation-exceptions-being-reported-on-bugsnag-despite-being-handled-and-ignored-in-laravel
     *
     * @todo Do R&D to fix issue with $dontReport skipping so that this method can be
     * removed
     *
     * @param Exception $exception
     *
     * @return bool true if exception should be reported otherwise false
     */
    private function shouldNotifyToBugSnag(Exception $exception): bool
    {
        array_push($this->dontReport, MethodNotAllowedHttpException::class);
        array_push($this->dontReport, NotFoundHttpException::class);
        array_push($this->dontReport, CustomException::class);
        foreach ($this->dontReport as $notAllowedException) {
            if ($exception instanceof $notAllowedException) {
                return false;
            }
        }

        return true;
    }

    /**
     * Render an exception into an HTTP response based on debug mode.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     * @return \Illuminate\Http\Response | Illuminate\Http\RedirectResponse
     */
    protected function renderExceptionBasedOnDebugMode($request, Exception $exception)
    {
        //if debug mode enabled or system is under maintenance mode, redirect to actual error page else show custom server error page
        return (config('app.debug') === true) || $exception instanceof MaintenanceModeException ? parent::render($request, $exception) : redirect('500');
    }

    /**
     * Response for exception for APIs.
     *
     * @param Exception $exception Exception instance
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseForApi($request, Exception $exception)
    {
        switch ($exception) {
            case $exception instanceof MethodNotAllowedHttpException:
                // Handle invalid HTTP method called
                return errorResponse(__('lang.method_not_allowed'), FAVEO_INVALID_METHOD_CODE);

            case $exception instanceof NotFoundHttpException:
                // Handle invalid end point called
                return errorResponse(__('lang.invalid-api-endpoint'), FAVEO_NOT_FOUND_CODE);

            case $exception instanceof ValidationException:
                return $this->invalidJson($request, $exception);

            default:
                // if debug mode is ON, actual exception message should go else internal-server-error
                return \Config::get('app.debug') ? exceptionResponse($exception) : errorResponse(__('lang.internal-server-error'), FAVEO_EXCEPTION_CODE);
        }
    }

    /**
     * Report database connection failed error.
     *
     * @param Exception $exception Exception instance
     *
     * @return HTTP Response
     */
    protected function reportDatabaseConnectionFailed(Exception $exception)
    {
        if ($exception instanceof PDOException) {
            /**
             * Handle PDOException of Unknown database name & invalid database credential.
             *
             * [1049] => Unknown database
             * [1045] => Access denied for user
             * [2002] => Database down or not running
             */
            if (in_array($exception->getCode(), [1045, 1049, 2002])) {
                echo '<h1>Database connection failed!!!</h1><p><a href="mailto:support@ladybirdweb.com">Report this event to developers</a></p>';

                throw new Exception($exception->getCode(), 1);
            }

            return parent::report($exception);
        }
    }
}
