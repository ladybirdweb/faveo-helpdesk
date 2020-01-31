<?php

namespace Bugsnag\PsrLogger;

use Bugsnag\Client;
use Bugsnag\Report;
use Exception;
use Psr\Log\LogLevel;
use Throwable;

class BugsnagLogger extends AbstractLogger
{
    /**
     * The bugsnag client instance.
     *
     * @var \Bugsnag\Client
     */
    protected $client;

    /**
     * The minimum level required to notify bugsnag.
     *
     * Logs underneath this level will be converted into breadcrumbs.
     *
     * @var string
     */
    protected $notifyLevel = LogLevel::NOTICE;

    /**
     * Create a new bugsnag logger instance.
     *
     * @param \Bugsnag\Client $client
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set the notifyLevel of the logger, as defined in Psr\Log\LogLevel.
     *
     * @param string $notifyLevel
     *
     * @return void
     */
    public function setNotifyLevel($notifyLevel)
    {
        if (!in_array($notifyLevel, $this->getLogLevelOrder())) {
            syslog(LOG_WARNING, 'Bugsnag Warning: Invalid notify level supplied to Bugsnag Logger');
        } else {
            $this->notifyLevel = $notifyLevel;
        }
    }

    /**
     * Log a message to the logs.
     *
     * @param string $level
     * @param mixed  $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $title = 'Log '.$level;
        if (isset($context['title'])) {
            $title = $context['title'];
            unset($context['title']);
        }

        $exception = null;
        if (isset($context['exception']) && ($context['exception'] instanceof Exception || $context['exception'] instanceof Throwable)) {
            $exception = $context['exception'];
            unset($context['exception']);
        } elseif ($message instanceof Exception || $message instanceof Throwable) {
            $exception = $message;
        }

        // Below theshold, leave a breadcrumb but don't send a notification
        if (!$this->aboveLevel($level, $this->notifyLevel)) {
            if ($exception !== null) {
                $title = get_class($exception);
                $data = ['name' => $title, 'message' => $exception->getMessage()];
            } else {
                $data = ['message' => $message];
            }

            $metaData = array_merge($data, $context);

            $this->client->leaveBreadcrumb($title, 'log', array_filter($metaData));

            return;
        }

        $severityReason = [
            'type' => 'log',
            'attributes' => [
                'level' => $level,
            ],
        ];

        if ($exception !== null) {
            $report = Report::fromPHPThrowable($this->client->getConfig(), $exception);
        } else {
            $report = Report::fromNamedError($this->client->getConfig(), $title, $this->formatMessage($message));
        }

        $report->setMetaData($context);
        $report->setSeverity($this->getSeverity($level));
        $report->setSeverityReason($severityReason);

        $this->client->notify($report);
    }

    /**
     * Checks whether the selected level is above another level.
     *
     * @param string $level
     * @param string $base
     *
     * @return bool
     */
    protected function aboveLevel($level, $base)
    {
        $levelOrder = $this->getLogLevelOrder();
        $baseIndex = array_search($base, $levelOrder);
        $levelIndex = array_search($level, $levelOrder);

        return $levelIndex >= $baseIndex;
    }

    /**
     * Returns the log levels in order.
     *
     * @return string[]
     */
    protected function getLogLevelOrder()
    {
        return [
            LogLevel::DEBUG,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
            LogLevel::ERROR,
            LogLevel::CRITICAL,
            LogLevel::ALERT,
            LogLevel::EMERGENCY,
        ];
    }

    /**
     * Get the severity for the logger.
     *
     * @param string $level
     *
     * @return string
     */
    protected function getSeverity($level)
    {
        if ($this->aboveLevel($level, 'error')) {
            return 'error';
        } elseif ($this->aboveLevel($level, 'warning')) {
            return 'warning';
        } else {
            return 'info';
        }
    }

    /**
     * Format the parameters for the logger.
     *
     * @param mixed $message
     *
     * @return string
     */
    protected function formatMessage($message)
    {
        if (is_array($message)) {
            return var_export($message, true);
        }

        return $message;
    }

    /**
     * Ensure the given string is less than 100 characters.
     *
     * @param string $str
     *
     * @return string
     */
    protected function limit($str)
    {
        if (strlen($str) <= 100) {
            return $str;
        }

        return rtrim(substr($str, 0, 97)).'...';
    }
}
