<?php

namespace Bugsnag;

use InvalidArgumentException;

class Configuration
{
    /**
     * The default endpoint.
     *
     * @var string
     */
    const SESSION_ENDPOINT = 'https://sessions.bugsnag.com';

    /**
     * The default build endpoint.
     *
     * @var string
     */
    const BUILD_ENDPOINT = 'https://build.bugsnag.com';

    /**
     * The Bugsnag API Key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * If batch sending is enabled.
     *
     * @var bool
     */
    protected $batchSending = true;

    /**
     * Which release stages should be allowed to notify.
     *
     * @var string[]|null
     */
    protected $notifyReleaseStages;

    /**
     * The strings to filter out from metaData.
     *
     * @var string[]
     */
    protected $filters = ['password'];

    /**
     * The project root regex.
     *
     * @var string
     */
    protected $projectRootRegex;

    /**
     * The strip path regex.
     *
     * @var string
     */
    protected $stripPathRegex;

    /**
     * If code sending is enabled.
     *
     * @var bool
     */
    protected $sendCode = true;

    /**
     * The notifier to report as.
     *
     * @var string[]
     */
    protected $notifier = [
        'name' => 'Bugsnag PHP (Official)',
        'version' => '3.20.0',
        'url' => 'https://bugsnag.com',
    ];

    /**
     * The fallback app type.
     *
     * @var string|null
     */
    protected $fallbackType;

    /**
     * The application data.
     *
     * @var string[]
     */
    protected $appData = [];

    /**
     * The device data.
     *
     * @var string[]
     */
    protected $deviceData = [];

    /**
     * The meta data.
     *
     * @var array[]
     */
    protected $metaData = [];

    /**
     * The error reporting level.
     *
     * @var int|null
     */
    protected $errorReportingLevel;

    /**
     * Whether to track sessions.
     *
     * @var bool
     */
    protected $autoCaptureSessions = false;

    /**
     * A client to use to send sessions.
     *
     * @var \Guzzle\ClientInterface
     */
    protected $sessionClient;

    /**
     * The endpoint to deliver sessions to.
     *
     * @var string
     */
    protected $sessionEndpoint = self::SESSION_ENDPOINT;

    /**
     * The endpoint to deliver build notifications to.
     *
     * @var string
     */
    protected $buildEndpoint;

    /**
     * Create a new config instance.
     *
     * @param string $apiKey your bugsnag api key
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function __construct($apiKey)
    {
        if (!is_string($apiKey)) {
            throw new InvalidArgumentException('Invalid API key');
        }

        $this->apiKey = $apiKey;
        $this->fallbackType = php_sapi_name();

        // Add PHP runtime version to device data
        $this->mergeDeviceData(['runtimeVersions' => ['php' => phpversion()]]);
    }

    /**
     * Get the Bugsnag API Key.
     *
     * @var string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets whether errors should be batched together and send at the end of each request.
     *
     * @param bool $batchSending whether to batch together errors
     *
     * @return $this
     */
    public function setBatchSending($batchSending)
    {
        $this->batchSending = $batchSending;

        return $this;
    }

    /**
     * Is batch sending is enabled?
     *
     * @return bool
     */
    public function isBatchSending()
    {
        return $this->batchSending;
    }

    /**
     * Set which release stages should be allowed to notify Bugsnag.
     *
     * Eg ['production', 'development'].
     *
     * @param string[]|null $notifyReleaseStages array of release stages to notify for
     *
     * @return $this
     */
    public function setNotifyReleaseStages(array $notifyReleaseStages = null)
    {
        $this->notifyReleaseStages = $notifyReleaseStages;

        return $this;
    }

    /**
     * Should we notify Bugsnag based on the current release stage?
     *
     * @return bool
     */
    public function shouldNotify()
    {
        if (!$this->notifyReleaseStages) {
            return true;
        }

        return in_array($this->getAppData()['releaseStage'], $this->notifyReleaseStages, true);
    }

    /**
     * Set the strings to filter out from metaData arrays before sending then.
     *
     * Eg. ['password', 'credit_card'].
     *
     * @param string[] $filters an array of metaData filters
     *
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Get the array of metaData filters.
     *
     * @var string
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the project root.
     *
     * @param string|null $projectRoot the project root path
     *
     * @return void
     */
    public function setProjectRoot($projectRoot)
    {
        $projectRootRegex = $projectRoot ? '/^'.preg_quote($projectRoot, '/').'[\\/]?/i' : null;
        $this->setProjectRootRegex($projectRootRegex);
    }

    /**
     * Set the project root regex.
     *
     * @param string|null $projectRootRegex the project root path
     *
     * @return void
     */
    public function setProjectRootRegex($projectRootRegex)
    {
        if ($projectRootRegex && @preg_match($projectRootRegex, null) === false) {
            throw new InvalidArgumentException('Invalid project root regex: '.$projectRootRegex);
        }

        $this->projectRootRegex = $projectRootRegex;
        $this->setStripPathRegex($projectRootRegex);
    }

    /**
     * Is the given file in the project?
     *
     * @param string $file
     *
     * @return string
     */
    public function isInProject($file)
    {
        return $this->projectRootRegex && preg_match($this->projectRootRegex, $file);
    }

    /**
     * Set the strip path.
     *
     * @param string|null $stripPath the absolute strip path
     *
     * @return void
     */
    public function setStripPath($stripPath)
    {
        $stripPathRegex = $stripPath ? '/^'.preg_quote($stripPath, '/').'[\\/]?/i' : null;
        $this->setStripPathRegex($stripPathRegex);
    }

    /**
     * Set the regular expression used to strip paths from stacktraces.
     *
     * @param string|null $stripPathRegex
     *
     * @return void
     */
    public function setStripPathRegex($stripPathRegex)
    {
        if ($stripPathRegex && @preg_match($stripPathRegex, null) === false) {
            throw new InvalidArgumentException('Invalid strip path regex: '.$stripPathRegex);
        }

        $this->stripPathRegex = $stripPathRegex;
    }

    /**
     * Set the stripped file path.
     *
     * @param string $file
     *
     * @return string
     */
    public function getStrippedFilePath($file)
    {
        return $this->stripPathRegex ? preg_replace($this->stripPathRegex, '', $file) : $file;
    }

    /**
     * Set if we should we send a small snippet of the code that crashed.
     *
     * This can help you diagnose even faster from within your dashboard.
     *
     * @param bool $sendCode whether to send code to Bugsnag
     *
     * @return $this
     */
    public function setSendCode($sendCode)
    {
        $this->sendCode = $sendCode;

        return $this;
    }

    /**
     * Should we send a small snippet of the code that crashed?
     *
     * @return bool
     */
    public function shouldSendCode()
    {
        return $this->sendCode;
    }

    /**
     * Sets the notifier to report as to Bugsnag.
     *
     * This should only be set by other notifier libraries.
     *
     * @param string[] $notifier an array of name, version, url.
     *
     * @return $this
     */
    public function setNotifier(array $notifier)
    {
        $this->notifier = $notifier;

        return $this;
    }

    /**
     * Get the notifier to report as to Bugsnag.
     *
     * @var string[]
     */
    public function getNotifier()
    {
        return $this->notifier;
    }

    /**
     * Set your app's semantic version, eg "1.2.3".
     *
     * @param string|null $appVersion the app's version
     *
     * @return $this
     */
    public function setAppVersion($appVersion)
    {
        $this->appData['version'] = $appVersion;

        return $this;
    }

    /**
     * Set your release stage, eg "production" or "development".
     *
     * @param string|null $releaseStage the app's current release stage
     *
     * @return $this
     */
    public function setReleaseStage($releaseStage)
    {
        $this->appData['releaseStage'] = $releaseStage;

        return $this;
    }

    /**
     * Set the type of application executing the code.
     *
     * This is usually used to represent if you are running plain PHP code
     * "php", via a framework, eg "laravel", or executing through delayed
     * worker code, eg "resque".
     *
     * @param string|null $type the current type
     *
     * @return $this
     */
    public function setAppType($type)
    {
        $this->appData['type'] = $type;

        return $this;
    }

    /**
     * Set the fallback application type.
     *
     * This is should be used only by libraries to set an fallback app type.
     *
     * @param string|null $type the fallback type
     *
     * @return $this
     */
    public function setFallbackType($type)
    {
        $this->fallbackType = $type;

        return $this;
    }

    /**
     * Get the application data.
     *
     * @return array
     */
    public function getAppData()
    {
        return array_merge(array_filter(['type' => $this->fallbackType, 'releaseStage' => 'production']), array_filter($this->appData));
    }

    /**
     * Set the hostname.
     *
     * @param string|null $hostname the hostname
     *
     * @return $this
     */
    public function setHostname($hostname)
    {
        $this->deviceData['hostname'] = $hostname;

        return $this;
    }

    /**
     * Adds new data fields to the device data collection.
     *
     * @param array $data an associative array containing the new data to be added
     *
     * @return this
     */
    public function mergeDeviceData($data)
    {
        $this->deviceData = array_merge_recursive($this->deviceData, $data);

        return $this;
    }

    /**
     * Get the device data.
     *
     * @return array
     */
    public function getDeviceData()
    {
        return array_merge($this->getHostname(), array_filter($this->deviceData));
    }

    /**
     * Get the hostname if possible.
     *
     * @return array
     */
    protected function getHostname()
    {
        $disabled = explode(',', ini_get('disable_functions'));

        if (function_exists('php_uname') && !in_array('php_uname', $disabled, true)) {
            return ['hostname' => php_uname('n')];
        }

        if (function_exists('gethostname') && !in_array('gethostname', $disabled, true)) {
            return ['hostname' => gethostname()];
        }

        return [];
    }

    /**
     * Set custom metadata to send to Bugsnag.
     *
     * You can use this to add custom tabs of data to each error on your
     * Bugsnag dashboard.
     *
     * @param array[] $metaData an array of arrays of custom data
     * @param bool    $merge    should we merge the meta data
     *
     * @return $this
     */
    public function setMetaData(array $metaData, $merge = true)
    {
        $this->metaData = $merge ? array_merge_recursive($this->metaData, $metaData) : $metaData;

        return $this;
    }

    /**
     * Get the custom metadata to send to Bugsnag.
     *
     * @return array[]
     */
    public function getMetaData()
    {
        return $this->metaData;
    }

    /**
     * Set Bugsnag's error reporting level.
     *
     * If this is not set, we'll use your current PHP error_reporting value
     * from your ini file or error_reporting(...) calls.
     *
     * @param int|null $errorReportingLevel the error reporting level integer
     *
     * @return $this
     */
    public function setErrorReportingLevel($errorReportingLevel)
    {
        $this->errorReportingLevel = $errorReportingLevel;

        return $this;
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
        $defaultReportingLevel = error_reporting();

        if ($defaultReportingLevel === 0) {
            // The error has been suppressed using the error control operator ('@')
            // Ignore the error in all cases.
            return true;
        }

        if (isset($this->errorReportingLevel)) {
            return !($this->errorReportingLevel & $code);
        }

        return !($defaultReportingLevel & $code);
    }

    /**
     * Set session tracking state and pass in optional guzzle.
     *
     * @param bool $track whether to track sessions
     *
     * @return $this
     */
    public function setAutoCaptureSessions($track)
    {
        $this->autoCaptureSessions = $track;

        return $this;
    }

    /**
     * Set session delivery endpoint.
     *
     * @param string $endpoint the session endpoint
     *
     * @return $this
     */
    public function setSessionEndpoint($endpoint)
    {
        $this->sessionEndpoint = $endpoint;

        $this->sessionClient = Client::makeGuzzle($this->sessionEndpoint);

        return $this;
    }

    /**
     * Get the session client.
     *
     * @return \Guzzle\ClientInterface
     */
    public function getSessionClient()
    {
        if (is_null($this->sessionClient)) {
            $this->sessionClient = Client::makeGuzzle($this->sessionEndpoint);
        }

        return $this->sessionClient;
    }

    /**
     * Whether should be auto-capturing sessions.
     *
     * @return bool
     */
    public function shouldCaptureSessions()
    {
        return $this->autoCaptureSessions;
    }

    /**
     * Sets the build endpoint.
     *
     * @param string $endpoint the build endpoint
     *
     * @return $this
     */
    public function setBuildEndpoint($endpoint)
    {
        $this->buildEndpoint = $endpoint;

        return $this;
    }

    /**
     * Returns the build endpoint.
     *
     * @return string
     */
    public function getBuildEndpoint()
    {
        if (isset($this->buildEndpoint)) {
            return $this->buildEndpoint;
        }

        return self::BUILD_ENDPOINT;
    }
}
