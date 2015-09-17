<?php

class Bugsnag_Client
{
    private $config;
    private $notification;

    /**
     * Initialize Bugsnag
     *
     * @param String $apiKey your Bugsnag API key
     */
    public function __construct($apiKey)
    {
        // Check API key has been passed
        if (!is_string($apiKey)) {
            throw new Exception('Bugsnag Error: Invalid API key');
        }

        // Create a configuration object
        $this->config = new Bugsnag_Configuration();
        $this->config->apiKey = $apiKey;

        // Build a Diagnostics object
        $this->diagnostics = new Bugsnag_Diagnostics($this->config);

        // Register a shutdown function to check for fatal errors
        // and flush any buffered errors
        register_shutdown_function(array($this, 'shutdownHandler'));
    }

    /**
     * Set your release stage, eg "production" or "development"
     *
     * @param String $releaseStage the app's current release stage
     */
    public function setReleaseStage($releaseStage)
    {
        $this->config->releaseStage = $releaseStage;

        return $this;
    }

    /**
     * Set your app's semantic version, eg "1.2.3"
     *
     * @param String $appVersion the app's version
     */
    public function setAppVersion($appVersion)
    {
        $this->config->appVersion = $appVersion;

        return $this;
    }

     /**
     * Set the host name
     *
     * @param String $hostname the host name
     */
    public function setHostname($hostname)
    {
        $this->config->hostname = $hostname;

        return $this;
    }

    /**
     * Set which release stages should be allowed to notify Bugsnag
     * eg array("production", "development")
     *
     * @param Array $notifyReleaseStages array of release stages to notify for
     */
    public function setNotifyReleaseStages(array $notifyReleaseStages)
    {
        $this->config->notifyReleaseStages = $notifyReleaseStages;

        return $this;
    }

    /**
     * Set which Bugsnag endpoint to send errors to.
     *
     * @param String $endpoint endpoint URL
     */
    public function setEndpoint($endpoint)
    {
        $this->config->endpoint = $endpoint;

        return $this;
    }

    /**
     * Set whether or not to use SSL when notifying bugsnag
     *
     * @param Boolean $useSSL whether to use SSL
     * @deprecated you can now pass full URLs to setEndpoint
     */
    public function setUseSSL($useSSL)
    {
        $this->config->useSSL = $useSSL;

        return $this;
    }

    /**
     * Set the desired timeout for cURL connection when notifying bugsnag
     *
     * @param Integer $timeout the desired timeout in seconds
     */
    public function setTimeout($timeout)
    {
        $this->config->timeout = $timeout;

        return $this;
    }

    /**
     * Set the absolute path to the root of your application.
     * We use this to help with error grouping and to highlight "in project"
     * stacktrace lines.
     *
     * @param String $projectRoot the root path for your application
     */
    public function setProjectRoot($projectRoot)
    {
        $this->config->setProjectRoot($projectRoot);

        return $this;
    }

    /**
     * Set the path that should be stripped from the beginning of
     * any stacktrace file line. This helps to normalise filenames
     * for grouping and reduces the noise in stack traces.
     *
     * @param String $stripPath the path to strip from filenames
     */
    public function setStripPath($stripPath)
    {
        $this->config->setStripPath($stripPath);

        return $this;
    }

    /**
     * Set the a regular expression for matching filenames in stacktrace lines
     * that are part of your application.
     *
     * @param String $projectRootRegex regex matching paths belong to your project
     */
    public function setProjectRootRegex($projectRootRegex)
    {
        $this->config->projectRootRegex = $projectRootRegex;

        return $this;
    }

    /**
     * Set the strings to filter out from metaData arrays before sending then
     * to Bugsnag. Eg. array("password", "credit_card")
     *
     * @param Array $filters an array of metaData filters
     */
    public function setFilters(array $filters)
    {
        $this->config->filters = $filters;

        return $this;
    }

    /**
     * Set information about the current user of your app, including
     * id, name and email.
     *
     * @param Array $user an array of user information. Eg:
     *        array(
     *            'name' => 'Bob Hoskins',
     *            'email' => 'bob@hoskins.com'
     *        )
     */
    public function setUser(array $user)
    {
        $this->config->user = $user;

        return $this;
    }

    /**
     * @deprecated deprecated since version 2.1
     */
    public function setUserId($userId)
    {
        if (!is_array($this->config->user)) {
            $this->config->user = array();
        }

        $this->config->user['id'] = $userId;

        return $this;
    }

    /**
     * Set a context representing the current type of request, or location in code.
     *
     * @param String $context the current context
     */
    public function setContext($context)
    {
        $this->config->context = $context;

        return $this;
    }

    /**
     * Set the type of application executing the code. This is usually used to
     * represent if you are running plain PHP code "php", via a framework,
     * eg "laravel", or executing through delayed worker code, eg "resque".
     *
     * @param String $type the current type
     */
    public function setType($type)
    {
        $this->config->type = $type;

        return $this;
    }

    /**
     * Set custom metadata to send to Bugsnag with every error. You can use
     * this to add custom tabs of data to each error on your Bugsnag dashboard
     *
     * @param Array $metaData an array of arrays of custom data. Eg:
     *        array(
     *            "user" => array(
     *                "name" => "James",
     *                "email" => "james@example.com"
     *            )
     *        )
     */
    public function setMetaData(array $metaData)
    {
        $this->config->metaData = $metaData;

        return $this;
    }

    /**
     * Set proxy configuration
     *
     * @param Array $proxySettings an array with proxy settings. Eg:
     *        array(
     *            'host'     => "bugsnag.com",
     *            'port'     => 42,
     *            'user'     => "username"
     *            'password' => "password123"
     *            )
     */
    public function setProxySettings(array $proxySettings)
    {
        $this->config->proxySettings = $proxySettings;

        return $this;
    }

    /**
     * Set custom curl options
     *
     * @param Array $curlOptions an array with curl options. Eg:
     *        array(
     *            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
     *            )
     */
    public function setCurlOptions(array $curlOptions)
    {
        $this->config->curlOptions = $curlOptions;

        return $this;
    }

    /**
     * Set a custom function to call before notifying Bugsnag of an error.
     * You can use this to call your own error handling functions, or to add
     * custom tabs of data to each error on your Bugsnag dashboard.
     *
     * // Adding meta-data example
     * function before_bugsnag_notify($error) {
     *     $error->addMetaData(array(
     *         "user" => array(
     *             "name" => "James"
     *         )
     *     ));
     * }
     * $bugsnag->setBeforeNotifyFunction("before_bugsnag_notify");
     *
    */
    public function setBeforeNotifyFunction($beforeNotifyFunction)
    {
        $this->config->beforeNotifyFunction = $beforeNotifyFunction;

        return $this;
    }

    /**
     * Set Bugsnag's error reporting level.
     * If this is not set, we'll use your current PHP error_reporting value
     * from your ini file or error_reporting(...) calls.
     *
     * @param Integer $errorReportingLevel the error reporting level integer
     *                exactly as you would pass to PHP's error_reporting
     */
    public function setErrorReportingLevel($errorReportingLevel)
    {
        $this->config->errorReportingLevel = $errorReportingLevel;

        return $this;
    }

    /**
     * Sets whether Bugsnag should be automatically notified of unhandled
     * exceptions and errors.
     *
     * @param Boolean $autoNotify whether to auto notify or not
     */
    public function setAutoNotify($autoNotify)
    {
        $this->config->autoNotify = $autoNotify;

        return $this;
    }

    /**
     * Sets whether errors should be batched together and send at the end of
     * each request.
     *
     * @param Boolean $batchSending whether to batch together errors
     */
    public function setBatchSending($batchSending)
    {
        $this->config->batchSending = $batchSending;

        return $this;
    }

    /**
     * Sets the notifier to report as to Bugsnag. This should only be
     * set by other notifier libraries.
     *
     * @param Array $notifier an array of name, version, url.
     */
    public function setNotifier($notifier)
    {
        $this->config->notifier = $notifier;

        return $this;
    }

    /**
     * Sets whether Bugsnag should send $_ENV with each error.
     *
     * @param Boolean $sendEnvironment whether to send the environment
     */
    public function setSendEnvironment($sendEnvironment)
    {
        $this->config->sendEnvironment = $sendEnvironment;

        return $this;
    }

    /**
     * Should we send a small snippet of the code that crashed to help you
     * diagnose even faster from within your dashboard.
     *
     * @param Boolean $setSendCode whether to send code to Bugsnag
     */
    public function setSendCode($sendCode)
    {
        $this->config->sendCode = $sendCode;

        return $this;
    }

    /**
     * Notify Bugsnag of a non-fatal/handled exception
     *
     * @param Exception $exception the exception to notify Bugsnag about
     * @param Array     $metaData  optional metaData to send with this error
     * @param String    $severity  optional severity of this error (fatal/error/warning/info)
     */
    public function notifyException(Exception $exception, array $metaData = null, $severity = null)
    {
        $error = Bugsnag_Error::fromPHPException($this->config, $this->diagnostics, $exception);
        $error->setSeverity($severity);

        $this->notify($error, $metaData);
    }

    /**
     * Notify Bugsnag of a non-fatal/handled error
     *
     * @param String $errorName    the name of the error, a short (1 word) string
     * @param String $errorMessage the error message
     * @param Array  $metaData     optional metaData to send with this error
     * @param String $severity     optional severity of this error (fatal/error/warning/info)
     */
    public function notifyError($name, $message, array $metaData = null, $severity = null)
    {
        $error = Bugsnag_Error::fromNamedError($this->config, $this->diagnostics, $name, $message);
        $error->setSeverity($severity);

        $this->notify($error, $metaData);
    }

    // Exception handler callback, should only be called internally by PHP's set_exception_handler
    public function exceptionHandler($exception)
    {
        if(!$this->config->autoNotify) {
            return;
        }

        $error = Bugsnag_Error::fromPHPException($this->config, $this->diagnostics, $exception);
        $error->setSeverity("error");
        $this->notify($error);
    }

    // Exception handler callback, should only be called internally by PHP's set_error_handler
    public function errorHandler($errno, $errstr, $errfile = '', $errline = 0)
    {
        if(!$this->config->autoNotify || $this->config->shouldIgnoreErrorCode($errno)) {
            return;
        }

        $error = Bugsnag_Error::fromPHPError($this->config, $this->diagnostics, $errno, $errstr, $errfile, $errline);
        $this->notify($error);
    }

    // Shutdown handler callback, called when the PHP process has finished running
    // Should only be called internally by PHP's register_shutdown_function
    public function shutdownHandler()
    {
        // Get last error
        $lastError = error_get_last();

        // Check if a fatal error caused this shutdown
        if (!is_null($lastError) && Bugsnag_ErrorTypes::isFatal($lastError['type']) && $this->config->autoNotify && !$this->config->shouldIgnoreErrorCode($lastError['type'])) {
            $error = Bugsnag_Error::fromPHPError($this->config, $this->diagnostics, $lastError['type'], $lastError['message'], $lastError['file'], $lastError['line'], true);
            $error->setSeverity("error");
            $this->notify($error);
        }

        // Flush any buffered errors
        if ($this->notification) {
            $this->notification->deliver();
            $this->notification = null;
        }
    }

    /**
     * Batches up errors into notifications for later sending
     *
     * @param Bugsnag_Error $error    the error to batch up
     * @param array         $metaData optional meta data to send with the error
     */
    public function notify(Bugsnag_Error $error, $metaData = array())
    {
        // Queue or send the error
        if ($this->sendErrorsOnShutdown()) {
            // Create a batch notification unless we already have one
            if (is_null($this->notification)) {
                $this->notification = new Bugsnag_Notification($this->config);
            }

            // Add this error to the notification
            $this->notification->addError($error, $metaData);
        } else {
            // Create and deliver notification immediately
            $notif = new Bugsnag_Notification($this->config);
            $notif->addError($error, $metaData);
            $notif->deliver();
        }
    }

    // Should we send errors immediately or on shutdown
    private function sendErrorsOnShutdown()
    {
        return $this->config->batchSending && Bugsnag_Request::isRequest();
    }
}
