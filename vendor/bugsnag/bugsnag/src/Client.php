<?php

namespace Bugsnag;

use Bugsnag\Breadcrumbs\Breadcrumb;
use Bugsnag\Breadcrumbs\Recorder;
use Bugsnag\Callbacks\GlobalMetaData;
use Bugsnag\Callbacks\RequestContext;
use Bugsnag\Callbacks\RequestCookies;
use Bugsnag\Callbacks\RequestMetaData;
use Bugsnag\Callbacks\RequestSession;
use Bugsnag\Callbacks\RequestUser;
use Bugsnag\Middleware\BreadcrumbData;
use Bugsnag\Middleware\CallbackBridge;
use Bugsnag\Middleware\NotificationSkipper;
use Bugsnag\Middleware\SessionData;
use Bugsnag\Request\BasicResolver;
use Bugsnag\Request\ResolverInterface;
use Bugsnag\Shutdown\PhpShutdownStrategy;
use Bugsnag\Shutdown\ShutdownStrategyInterface;
use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface;
use ReflectionClass;
use ReflectionException;

class Client
{
    /**
     * The default endpoint.
     *
     * @var string
     */
    const ENDPOINT = 'https://notify.bugsnag.com';

    /**
     * The config instance.
     *
     * @var \Bugsnag\Configuration
     */
    protected $config;

    /**
     * The request resolver instance.
     *
     * @var \Bugsnag\Request\ResolverInterface
     */
    protected $resolver;

    /**
     * The breadcrumb recorder instance.
     *
     * @var \Bugsnag\Breadcrumbs\Recorder
     */
    protected $recorder;

    /**
     * The notification pipeline instance.
     *
     * @var \Bugsnag\Pipeline
     */
    protected $pipeline;

    /**
     * The http client instance.
     *
     * @var \Bugsnag\HttpClient
     */
    protected $http;

    /**
     * The session tracker instance.
     *
     * @var \Bugsnag\SessionTracker
     */
    protected $sessionTracker;

    /**
     * Make a new client instance.
     *
     * If you don't pass in a key, we'll try to read it from the env variables.
     *
     * @param string|null $apiKey   your bugsnag api key
     * @param string|null $endpoint your bugsnag endpoint
     * @param bool        $default  if we should register our default callbacks
     *
     * @return static
     */
    public static function make($apiKey = null, $endpoint = null, $defaults = true)
    {
        // Retrieves environment variables
        $env = new Env();

        $config = new Configuration($apiKey ?: $env->get('BUGSNAG_API_KEY'));
        $guzzle = static::makeGuzzle($endpoint ?: $env->get('BUGSNAG_ENDPOINT'));

        $client = new static($config, null, $guzzle);

        if ($defaults) {
            $client->registerDefaultCallbacks();
        }

        return $client;
    }

    /**
     * Create a new client instance.
     *
     * @param \Bugsnag\Configuration                            $config
     * @param \Bugsnag\Request\ResolverInterface|null           $resolver
     * @param \GuzzleHttp\ClientInterface|null                  $guzzle
     * @param \Bugsnag\Shutdown\ShutdownStrategyInterface|null  $shutdownStrategy
     *
     * @return void
     */
    public function __construct(Configuration $config, ResolverInterface $resolver = null, ClientInterface $guzzle = null, ShutdownStrategyInterface $shutdownStrategy = null)
    {
        $this->config = $config;
        $this->resolver = $resolver ?: new BasicResolver();
        $this->recorder = new Recorder();
        $this->pipeline = new Pipeline();
        $this->http = new HttpClient($config, $guzzle ?: static::makeGuzzle());
        $this->sessionTracker = new SessionTracker($config);

        $this->registerMiddleware(new NotificationSkipper($config));
        $this->registerMiddleware(new BreadcrumbData($this->recorder));
        $this->registerMiddleware(new SessionData($this));

        // Shutdown strategy is used to trigger flush() calls when batch sending is enabled
        $shutdownStrategy = $shutdownStrategy ?: new PhpShutdownStrategy();
        $shutdownStrategy->registerShutdownStrategy($this);
    }

    /**
     * Make a new guzzle client instance.
     *
     * @param string|null $base
     * @param array       $options
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public static function makeGuzzle($base = null, array $options = [])
    {
        $key = method_exists(ClientInterface::class, 'request') ? 'base_uri' : 'base_url';

        $options[$key] = $base ?: static::ENDPOINT;

        if ($path = static::getCaBundlePath()) {
            $options['verify'] = $path;
        }

        return new Guzzle($options);
    }

    /**
     * Get the ca bundle path if one exists.
     *
     * @return string|false
     */
    protected static function getCaBundlePath()
    {
        if (version_compare(PHP_VERSION, '5.6.0') >= 0 || !class_exists(CaBundle::class)) {
            return false;
        }

        return realpath(CaBundle::getSystemCaRootBundlePath());
    }

    /**
     * Get the config instance.
     *
     * @return \Bugsnag\Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get the pipeline instance.
     *
     * @return \Bugsnag\Pipeline
     */
    public function getPipeline()
    {
        return $this->pipeline;
    }

    /**
     * Regsier a new notification callback.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function registerCallback(callable $callback)
    {
        $this->registerMiddleware(new CallbackBridge($callback));

        return $this;
    }

    /**
     * Regsier all our default callbacks.
     *
     * @return $this
     */
    public function registerDefaultCallbacks()
    {
        $this->registerCallback(new GlobalMetaData($this->config))
             ->registerCallback(new RequestMetaData($this->resolver))
             ->registerCallback(new RequestCookies($this->resolver))
             ->registerCallback(new RequestSession($this->resolver))
             ->registerCallback(new RequestUser($this->resolver))
             ->registerCallback(new RequestContext($this->resolver));

        return $this;
    }

    /**
     * Register a middleware object to the pipeline.
     *
     * @param callable $middleware
     *
     * @return $this
     */
    public function registerMiddleware(callable $middleware)
    {
        $this->pipeline->pipe($middleware);

        return $this;
    }

    /**
     * Record the given breadcrumb.
     *
     * @param string      $name     the name of the breadcrumb
     * @param string|null $type     the type of breadcrumb
     * @param array       $metaData additional information about the breadcrumb
     *
     * @return void
     */
    public function leaveBreadcrumb($name, $type = null, array $metaData = [])
    {
        try {
            $name = (new ReflectionClass($name))->getShortName();
        } catch (ReflectionException $e) {
            //
        }

        $type = in_array($type, Breadcrumb::getTypes(), true) ? $type : Breadcrumb::MANUAL_TYPE;

        $this->recorder->record(new Breadcrumb($name, $type, $metaData));
    }

    /**
     * Clear all recorded breadcrumbs.
     *
     * @return void
     */
    public function clearBreadcrumbs()
    {
        $this->recorder->clear();
    }

    /**
     * Notify Bugsnag of a non-fatal/handled throwable.
     *
     * @param \Throwable    $throwable the throwable to notify Bugsnag about
     * @param callable|null $callback  the customization callback
     *
     * @return void
     */
    public function notifyException($throwable, callable $callback = null)
    {
        $report = Report::fromPHPThrowable($this->config, $throwable);

        $this->notify($report, $callback);
    }

    /**
     * Notify Bugsnag of a non-fatal/handled error.
     *
     * @param string        $name     the name of the error, a short (1 word) string
     * @param string        $message  the error message
     * @param callable|null $callback the customization callback
     *
     * @return void
     */
    public function notifyError($name, $message, callable $callback = null)
    {
        $report = Report::fromNamedError($this->config, $name, $message);

        $this->notify($report, $callback);
    }

    /**
     * Notify Bugsnag of the given error report.
     *
     * This may simply involve queuing it for later if we're batching.
     *
     * @param \Bugsnag\Report $report   the error report to send
     * @param callable|null   $callback the customization callback
     *
     * @return void
     */
    public function notify(Report $report, callable $callback = null)
    {
        $this->pipeline->execute($report, function ($report) use ($callback) {
            if ($callback) {
                $resolvedReport = null;

                $bridge = new CallbackBridge($callback);
                $bridge($report, function ($report) use (&$resolvedReport) {
                    $resolvedReport = $report;
                });
                if ($resolvedReport) {
                    $report = $resolvedReport;
                } else {
                    return;
                }
            }

            $this->http->queue($report);
        });

        $this->leaveBreadcrumb($report->getName(), Breadcrumb::ERROR_TYPE, $report->getSummary());

        if (!$this->config->isBatchSending()) {
            $this->flush();
        }
    }

    /**
     * Notify Bugsnag of a deployment.
     *
     * @deprecated This function is being deprecated in favour of `build`.
     *
     * @param string|null $repository the repository from which you are deploying the code
     * @param string|null $branch     the source control branch from which you are deploying
     * @param string|null $revision   the source control revision you are currently deploying
     *
     * @return void
     */
    public function deploy($repository = null, $branch = null, $revision = null)
    {
        $this->build($repository, $revision);
    }

    /**
     * Notify Bugsnag of a build.
     *
     * @param string|null $repository  the repository from which you are deploying the code
     * @param string|null $revision    the source control revision you are currently deploying
     * @param string|null $provider    the provider of the source control for the build
     * @param string|null $builderName the name of who or what is making the build
     *
     * @return void
     */
    public function build($repository = null, $revision = null, $provider = null, $builderName = null)
    {
        $data = [];

        if ($repository) {
            $data['repository'] = $repository;
        }

        if ($revision) {
            $data['revision'] = $revision;
        }

        if ($provider) {
            $data['provider'] = $provider;
        }

        if ($builderName) {
            $data['builder'] = $builderName;
        }

        $this->http->sendBuildReport($data);
    }

    /**
     * Flush any buffered reports.
     *
     * @return void
     */
    public function flush()
    {
        $this->http->send();
    }

    /**
     * Start tracking a session.
     *
     * @return void
     */
    public function startSession()
    {
        $this->sessionTracker->startSession();
    }

    /**
     * Returns the session tracker.
     *
     * @return \Bugsnag\SessionTracker
     */
    public function getSessionTracker()
    {
        return $this->sessionTracker;
    }

    // Forward calls to Configuration:

    /**
     * Get the Bugsnag API Key.
     *
     * @var string
     */
    public function getApiKey()
    {
        return $this->config->getApiKey();
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
        $this->config->setBatchSending($batchSending);

        return $this;
    }

    /**
     * Is batch sending is enabled?
     *
     * @return bool
     */
    public function isBatchSending()
    {
        return $this->config->isBatchSending();
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
        $this->config->setNotifyReleaseStages($notifyReleaseStages);

        return $this;
    }

    /**
     * Should we notify Bugsnag based on the current release stage?
     *
     * @return bool
     */
    public function shouldNotify()
    {
        return $this->config->shouldNotify();
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
        $this->config->setFilters($filters);

        return $this;
    }

    /**
     * Get the array of metaData filters.
     *
     * @var string
     */
    public function getFilters()
    {
        return $this->config->getFilters();
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
        $this->config->setProjectRoot($projectRoot);
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
        $this->config->setProjectRootRegex($projectRootRegex);
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
        return $this->config->isInProject($file);
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
        $this->config->setStripPath($stripPath);
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
        $this->config->setStripPathRegex($stripPathRegex);
    }

    /**
     * Get the stripped file path.
     *
     * @param string $file
     *
     * @return string
     */
    public function getStrippedFilePath($file)
    {
        return $this->config->getStrippedFilePath($file);
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
        $this->config->setSendCode($sendCode);

        return $this;
    }

    /**
     * Should we send a small snippet of the code that crashed?
     *
     * @return bool
     */
    public function shouldSendCode()
    {
        return $this->config->shouldSendCode();
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
        $this->config->setNotifier($notifier);

        return $this;
    }

    /**
     * Get the notifier to report as to Bugsnag.
     *
     * @var string[]
     */
    public function getNotifier()
    {
        return $this->config->getNotifier();
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
        $this->config->setAppVersion($appVersion);

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
        $this->config->setReleaseStage($releaseStage);

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
        $this->config->setAppType($type);

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
        $this->config->setFallbackType($type);

        return $this;
    }

    /**
     * Get the application data.
     *
     * @return array
     */
    public function getAppData()
    {
        return $this->config->getAppData();
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
        $this->config->setHostname($hostname);

        return $this;
    }

    /**
     * Get the device data.
     *
     * @return array
     */
    public function getDeviceData()
    {
        return $this->config->getDeviceData();
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
        $this->config->setMetaData($metaData, $merge);

        return $this;
    }

    /**
     * Get the custom metadata to send to Bugsnag.
     *
     * @return array[]
     */
    public function getMetaData()
    {
        return $this->config->getMetaData();
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
        $this->config->setErrorReportingLevel($errorReportingLevel);

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
        return $this->config->shouldIgnoreErrorCode($code);
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
        $this->config->setAutoCaptureSessions($track);

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
        $this->config->setSessionEndpoint($endpoint);

        return $this;
    }

    /**
     * Get the session client.
     *
     * @return \Guzzle\ClientInterface
     */
    public function getSessionClient()
    {
        return $this->config->getSessionClient();
    }

    /**
     * Whether should be auto-capturing sessions.
     *
     * @return bool
     */
    public function shouldCaptureSessions()
    {
        return $this->config->shouldCaptureSessions();
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
        $this->config->setBuildEndpoint($endpoint);

        return $this;
    }

    /**
     * Returns the build endpoint.
     *
     * @return string
     */
    public function getBuildEndpoint()
    {
        return $this->config->getBuildEndpoint();
    }
}
