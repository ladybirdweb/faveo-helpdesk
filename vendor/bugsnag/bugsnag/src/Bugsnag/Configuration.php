<?php

class Bugsnag_Configuration
{
    public static $DEFAULT_TIMEOUT = 10;
    public static $DEFAULT_ENDPOINT = 'https://notify.bugsnag.com';
    public static $DEFAULT_NON_SSL_ENDPOINT = 'http://notify.bugsnag.com';

    public $apiKey;
    public $autoNotify = true;
    public $batchSending = true;
    public $useSSL = true;
    public $endpoint;
    public $notifyReleaseStages;
    public $filters = array('password');
    public $projectRoot;
    public $projectRootRegex;
    public $proxySettings = array();
    public $notifier = array(
        'name' => 'Bugsnag PHP (Official)',
        'version' => '2.9.2',
        'url' => 'https://bugsnag.com',
    );
    public $sendEnvironment = false;
    public $sendCookies = true;
    public $sendSession = true;
    public $sendCode = true;
    public $stripPath;
    public $stripPathRegex;

    public $context;
    public $type;
    public $user;
    public $releaseStage = 'production';
    public $appVersion;
    public $hostname;

    public $metaData;
    public $beforeNotifyFunction;
    public $errorReportingLevel;

    public $curlOptions = array();

    public $debug = false;

    /**
     * Create a new config instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->timeout = self::$DEFAULT_TIMEOUT;
    }

    /**
     * Get the notify endpoint.
     *
     * @return string
     */
    public function getNotifyEndpoint()
    {
        if (is_null($this->endpoint)) {
            return $this->useSSL ? self::$DEFAULT_ENDPOINT : self::$DEFAULT_NON_SSL_ENDPOINT;
        } elseif (preg_match('/^(http:\/\/|https:\/\/)/', $this->endpoint)) {
            return $this->endpoint;
        } else {
            return ($this->useSSL ? 'https' : 'http').'://'.$this->endpoint;
        }
    }

    /**
     * Should we notify?
     *
     * @return bool
     */
    public function shouldNotify()
    {
        return is_null($this->notifyReleaseStages) || (is_array($this->notifyReleaseStages) && in_array($this->releaseStage, $this->notifyReleaseStages));
    }

    /**
     * Should we ignore the given error code?
     *
     * @param int $code the error code
     *
     * @return bool
     */
    public function shouldIgnoreErrorCode($code)
    {
        if (isset($this->errorReportingLevel)) {
            return !($this->errorReportingLevel & $code);
        } else {
            return !(error_reporting() & $code);
        }
    }

    /**
     * Set the project root.
     *
     * @param string $projectRoot the project root path
     *
     * @return void
     */
    public function setProjectRoot($projectRoot)
    {
        $this->projectRoot = $projectRoot;
        $this->projectRootRegex = '/'.preg_quote($projectRoot, '/').'[\\/]?/i';
        if (is_null($this->stripPath)) {
            $this->setStripPath($projectRoot);
        }
    }

    /**
     * Set the strip path.
     *
     * @param string $stripPath the absolute strip path
     *
     * @return void
     */
    public function setStripPath($stripPath)
    {
        $this->stripPath = $stripPath;
        $this->stripPathRegex = '/'.preg_quote($stripPath, '/').'[\\/]?/i';
    }

    /**
     * Get the given configuration.
     *
     * @param string $prop    the property to get
     * @param mixed  $default the value to fallback to
     *
     * @return mixed
     */
    public function get($prop, $default = null)
    {
        $configured = $this->$prop;

        if (is_array($configured) && is_array($default)) {
            return array_merge($default, $configured);
        } else {
            return $configured ? $configured : $default;
        }
    }
}
