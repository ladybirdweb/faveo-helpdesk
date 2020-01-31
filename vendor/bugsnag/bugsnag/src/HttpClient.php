<?php

namespace Bugsnag;

use Exception;
use GuzzleHttp\ClientInterface;
use RuntimeException;

class HttpClient
{
    /**
     * The config instance.
     *
     * @var \Bugsnag\Configuration
     */
    protected $config;

    /**
     * The guzzle client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $guzzle;

    /**
     * The queue of reports to send.
     *
     * @var \Bugsnag\Report[]
     */
    protected $queue = [];

    /**
     * The maximum payload size. A whole megabyte (1024 * 1024).
     *
     * @var int
     */
    const MAX_SIZE = 1048576;

    /**
     * The current payload version.
     *
     * @var string
     */
    const PAYLOAD_VERSION = '4.0';

    /**
     * Create a new http client instance.
     *
     * @param \Bugsnag\Configuration      $config the configuration instance
     * @param \GuzzleHttp\ClientInterface $guzzle the guzzle client instance
     *
     * @return void
     */
    public function __construct(Configuration $config, ClientInterface $guzzle)
    {
        $this->config = $config;
        $this->guzzle = $guzzle;
    }

    /**
     * Add a report to the queue.
     *
     * @param \Bugsnag\Report $report the bugsnag report instance
     *
     * @return void
     */
    public function queue(Report $report)
    {
        $this->queue[] = $report;
    }

    /**
     * Notify Bugsnag of a deployment.
     *
     * @deprecated This method should no longer be used in favour of sendBuildReport.
     *
     * @param array $data the deployment information
     *
     * @return void
     */
    public function deploy(array $data)
    {
        $app = $this->config->getAppData();

        $data['releaseStage'] = $app['releaseStage'];

        if (isset($app['version'])) {
            $data['appVersion'] = $app['version'];
        }

        $data['apiKey'] = $this->config->getApiKey();

        $this->post('deploy', ['json' => $data]);
    }

    /**
     * Notify Bugsnag of a build.
     *
     * @param array $buildInfo the build information
     *
     * @return void
     */
    public function sendBuildReport(array $buildInfo)
    {
        $app = $this->config->getAppData();

        $data = [];
        $sourceControl = [];

        if (isset($app['version'])) {
            $data['appVersion'] = $app['version'];
        } else {
            error_log('Bugsnag Warning: App version is not set. Unable to send build report.');

            return;
        }

        if (isset($buildInfo['repository'])) {
            $sourceControl['repository'] = $buildInfo['repository'];
        }

        if (isset($buildInfo['provider'])) {
            $sourceControl['provider'] = $buildInfo['provider'];
        }

        if (isset($buildInfo['revision'])) {
            $sourceControl['revision'] = $buildInfo['revision'];
        }

        if (!empty($sourceControl)) {
            $data['sourceControl'] = $sourceControl;
        }

        if (isset($buildInfo['builder'])) {
            $data['builderName'] = $buildInfo['builder'];
        } else {
            $data['builderName'] = Utils::getBuilderName();
        }

        if (isset($buildInfo['buildTool'])) {
            $data['buildTool'] = $buildInfo['buildTool'];
        } else {
            $data['buildTool'] = 'bugsnag-php';
        }

        $data['releaseStage'] = $app['releaseStage'];

        $data['apiKey'] = $this->config->getApiKey();

        $endpoint = $this->config->getBuildEndpoint();

        $this->post($endpoint, ['json' => $data]);
    }

    /**
     * Deliver everything on the queue to Bugsnag.
     *
     * @return void
     */
    public function send()
    {
        if (!$this->queue) {
            return;
        }

        $this->postJson('', $this->build());

        $this->queue = [];
    }

    /**
     * Build the request data to send.
     *
     * @return array
     */
    protected function build()
    {
        $events = [];

        foreach ($this->queue as $report) {
            $event = $report->toArray();

            if ($event) {
                $events[] = $event;
            }
        }

        return [
            'apiKey' => $this->config->getApiKey(),
            'notifier' => $this->config->getNotifier(),
            'events' => $events,
        ];
    }

    /**
     * Builds the array of headers to send.
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Bugsnag-Api-Key' => $this->config->getApiKey(),
            'Bugsnag-Sent-At' => strftime('%Y-%m-%dT%H:%M:%S'),
            'Bugsnag-Payload-Version' => self::PAYLOAD_VERSION,
        ];
    }

    /**
     * Send a POST request to Bugsnag.
     *
     * @param string $uri  the uri to hit
     * @param array  $data the request options
     *
     * @return void
     */
    protected function post($uri, array $options = [])
    {
        if (method_exists(ClientInterface::class, 'request')) {
            $this->guzzle->request('POST', $uri, $options);
        } else {
            $this->guzzle->post($uri, $options);
        }
    }

    /**
     * Post the given data to Bugsnag in json form.
     *
     * @param string $uri  the uri to hit
     * @param array  $data the data send
     *
     * @return void
     */
    protected function postJson($uri, array $data)
    {
        // Try to send the whole lot, or without the meta data for the first
        // event. If failed, try to send the first event, and then the rest of
        // them, recursively. Decrease by a constant and concquer if you like.
        // Note that the base case is satisfied as soon as the payload is small
        // enought to send, or when it's simply discarded.
        try {
            $normalized = $this->normalize($data);
        } catch (RuntimeException $e) {
            if (count($data['events']) > 1) {
                $event = array_shift($data['events']);
                $this->postJson($uri, array_merge($data, ['events' => [$event]]));
                $this->postJson($uri, $data);
            } else {
                error_log('Bugsnag Warning: '.$e->getMessage());
            }

            return;
        }

        // Send via guzzle and log any failures
        try {
            $this->post($uri, [
                'json' => $normalized,
                'headers' => $this->getHeaders(),
            ]);
        } catch (Exception $e) {
            error_log('Bugsnag Warning: Couldn\'t notify. '.$e->getMessage());
        }
    }

    /**
     * Normalize the given data to ensure it's the correct size.
     *
     * @param array $data the data to normalize
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function normalize(array $data)
    {
        $body = json_encode($data);

        if ($this->length($body) > static::MAX_SIZE) {
            unset($data['events'][0]['metaData']);
        }

        $body = json_encode($data);

        if ($this->length($body) > static::MAX_SIZE) {
            throw new RuntimeException('Payload too large');
        }

        return $data;
    }

    /**
     * Get the length of the given string in bytes.
     *
     * @param string $str the string to get the length of
     *
     * @return int
     */
    protected function length($str)
    {
        return function_exists('mb_strlen') ? mb_strlen($str, '8bit') : strlen($str);
    }
}
