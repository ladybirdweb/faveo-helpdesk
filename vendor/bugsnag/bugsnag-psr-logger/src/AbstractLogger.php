<?php

namespace Bugsnag\PsrLogger;

abstract class AbstractLogger implements \Psr\Log\LoggerInterface
{
    /**
     * Log an emergency message to the logs.
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = [])
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * Log an alert message to the logs.
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->log('alert', $message, $context);
    }

    /**
     * Log a critical message to the logs.
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->log('critical', $message, $context);
    }

    /**
     * Log an error message to the logs.
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->log('error', $message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->log('warning', $message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->log('notice', $message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->log('debug', $message, $context);
    }
}
