<?php

/*
 * This file is part of NotificationPusher.
 *
 * (c) 2013 Cédric Dugat <cedric@dugat.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sly\NotificationPusher\Adapter;

use InvalidArgumentException;
use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Exception\PushException;
use Sly\NotificationPusher\Model\BaseOptionedModel;
use Sly\NotificationPusher\Model\DeviceInterface;
use Sly\NotificationPusher\Model\GcmMessage;
use Sly\NotificationPusher\Model\PushInterface;
use Zend\Http\Client as HttpClient;
use Zend\Http\Client\Adapter\Socket as HttpSocketAdapter;
use ZendService\Google\Exception\RuntimeException as ServiceRuntimeException;
use ZendService\Google\Gcm\Client as ServiceClient;
use ZendService\Google\Gcm\Message as ServiceMessage;

/**
 * GCM adapter.
 *
 * @uses \Sly\NotificationPusher\Adapter\BaseAdapter
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Gcm extends BaseAdapter
{
    /**
     * @var \Zend\Http\Client
     */
    private $httpClient;

    /**
     * @var ServiceClient
     */
    private $openedClient;

    /**
     * {@inheritdoc}
     */
    public function supports($token)
    {
        return is_string($token) && $token !== '';
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Sly\NotificationPusher\Exception\PushException
     */
    public function push(PushInterface $push)
    {
        $client        = $this->getOpenedClient();
        $pushedDevices = new DeviceCollection();
        $tokens        = array_chunk($push->getDevices()->getTokens(), 100);

        foreach ($tokens as $tokensRange) {
            $message = $this->getServiceMessageFromOrigin($tokensRange, $push->getMessage());

            try {

                /** @var \ZendService\Google\Gcm\Response $response */
                $response        = $client->send($message);
                $responseResults = $response->getResults();

                foreach ($tokensRange as $token) {
                    /** @var DeviceInterface $device */
                    $device = $push->getDevices()->get($token);

                    // map the overall response object
                    // into a per device response
                    $tokenResponse = [];
                    if (isset($responseResults[$token]) && is_array($responseResults[$token])) {
                        $tokenResponse = $responseResults[$token];
                    }

                    $responseData = $response->getResponse();
                    if ($responseData && is_array($responseData)) {
                        $tokenResponse = array_merge(
                            $tokenResponse,
                            array_diff_key($responseData, ['results' => true])
                        );
                    }

                    $push->addResponse($device, $tokenResponse);

                    $pushedDevices->add($device);

                    $this->response->addOriginalResponse($device, $response);
                    $this->response->addParsedResponse($device, $tokenResponse);
                }
            } catch (ServiceRuntimeException $e) {
                throw new PushException($e->getMessage());
            }
        }

        return $pushedDevices;
    }

    /**
     * Get opened client.
     *
     * @return \ZendService\Google\Gcm\Client
     */
    public function getOpenedClient()
    {
        if (!isset($this->openedClient)) {
            $this->openedClient = new ServiceClient();
            $this->openedClient->setApiKey($this->getParameter('apiKey'));

            $newClient = new \Zend\Http\Client(
                null,
                [
                    'adapter'       => 'Zend\Http\Client\Adapter\Socket',
                    'sslverifypeer' => false,
                ]
            );

            $this->openedClient->setHttpClient($newClient);
        }

        return $this->openedClient;
    }

    /**
     * Get service message from origin.
     *
     * @param array $tokens Tokens
     * @param BaseOptionedModel|\Sly\NotificationPusher\Model\MessageInterface $message Message
     *
     * @return \ZendService\Google\Gcm\Message
     * @throws \ZendService\Google\Exception\InvalidArgumentException
     */
    public function getServiceMessageFromOrigin(array $tokens, BaseOptionedModel $message)
    {
        $data            = $message->getOptions();
        $data['message'] = $message->getText();

        $serviceMessage = new ServiceMessage();
        $serviceMessage->setRegistrationIds($tokens);

        if (isset($data['notificationData']) && !empty($data['notificationData'])) {
            $serviceMessage->setNotification($data['notificationData']);
            unset($data['notificationData']);
        }

        if ($message instanceof GcmMessage) {
            $serviceMessage->setNotification($message->getNotificationData());
        }

        $serviceMessage->setData($data);

        $serviceMessage->setCollapseKey($this->getParameter('collapseKey'));
        $serviceMessage->setRestrictedPackageName($this->getParameter('restrictedPackageName'));
        $serviceMessage->setDelayWhileIdle($this->getParameter('delayWhileIdle', false));
        $serviceMessage->setTimeToLive($this->getParameter('ttl', 600));
        $serviceMessage->setDryRun($this->getParameter('dryRun', false));

        return $serviceMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinedParameters()
    {
        return [
            'collapseKey',
            'delayWhileIdle',
            'ttl',
            'restrictedPackageName',
            'dryRun',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredParameters()
    {
        return ['apiKey'];
    }

    /**
     * Get the current Zend Http Client instance.
     *
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Overrides the default Http Client.
     *
     * @param HttpClient $client
     */
    public function setHttpClient(HttpClient $client)
    {
        $this->httpClient = $client;
    }

    /**
     * Send custom parameters to the Http Adapter without overriding the Http Client.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     */
    public function setAdapterParameters(array $config = [])
    {
        if (!is_array($config) || empty($config)) {
            throw new InvalidArgumentException('$config must be an associative array with at least 1 item.');
        }

        if ($this->httpClient === null) {
            $this->httpClient = new HttpClient();
            $this->httpClient->setAdapter(new HttpSocketAdapter());
        }

        $this->httpClient->getAdapter()->setOptions($config);
    }
}
