<?php

namespace Bugsnag\BugsnagLaravel\Middleware;

use Bugsnag\Report;

class UnhandledState
{
    /**
     * Unhandled state middleware implementation details.
     *
     * This middleware functions on the basis of three things:
     * 1. All unhandled exceptions must pass through the `HANDLER_CLASS` report
     *    method
     * 2. Unhandled exceptions will have had a caller from inside the Illuminate
     *    namespace or App exception handler
     * 3. The above exception handler must have originally been called from
     *    within the Illuminate namespace
     *
     * This middleware calls the inbuilt PHP backtrace, and traverses each frame
     * to determine if the above conditions are met.  If they are, the report is
     * marked as unhandled.
     */
    const HANDLER_CLASS = 'Illuminate\\Foundation\\Exceptions\\Handler';
    const HANDLER_METHOD = 'report';
    const ILLUMINATE_NAMESPACE = 'Illuminate';
    const APP_EXCEPTION_HANDLER = 'App\\Exception\\Handler';

    /**
     * Execute the unhandled state middleware.
     *
     * @param \Bugsnag\Report $report the bugsnag report instance
     * @param callable        $next   the next stage callback
     *
     * @return void
     */
    public function __invoke(Report $report, callable $next)
    {
        $stackFrames = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $reportFrame = false;
        $callerFrame = false;
        $unhandled = false;
        if (is_null($stackFrames)) {
            return;
        }
        foreach ($stackFrames as $frame) {
            if (!array_key_exists('class', $frame)) {
                continue;
            }
            $class = $frame['class'];
            if (!$reportFrame) {
                if (!array_key_exists('function', $frame)) {
                    continue;
                } elseif (($class === $this::HANDLER_CLASS) && ($frame['function'] === $this::HANDLER_METHOD)) {
                    $reportFrame = true;
                }
            } elseif (!$callerFrame) {
                $startsWithIlluminate = substr($class, 0, strlen($this::ILLUMINATE_NAMESPACE)) === $this::ILLUMINATE_NAMESPACE;
                if ($startsWithIlluminate || ($class == $this::APP_EXCEPTION_HANDLER)) {
                    $callerFrame = true;
                }
            } elseif (!$unhandled) {
                $startsWithIlluminate = substr($class, 0, strlen($this::ILLUMINATE_NAMESPACE)) === $this::ILLUMINATE_NAMESPACE;
                if ($startsWithIlluminate) {
                    $unhandled = true;
                }
                break;
            }
        }
        if ($unhandled) {
            $report->setUnhandled(true);
            $report->setSeverityReason([
                'type' => 'unhandledExceptionMiddleware',
                'attributes' => [
                    'framework' => 'Laravel',
                ],
            ]);
        }
        $next($report);
    }

    protected function stringStartsWith($haystack, $needle)
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}
