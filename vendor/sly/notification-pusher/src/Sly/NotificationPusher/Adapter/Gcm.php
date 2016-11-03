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

use Sly\NotificationPusher\Model\BaseOptionedModel;
use Sly\NotificationPusher\Model\PushInterface;
use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Exception\PushException;

use Zend\Http\Client as HttpClient;
use Zend\Http\Client\Adapter\Socket as HttpSocketAdapter;

use ZendService\Google\Gcm\Client as ServiceClient;
use ZendService\Google\Gcm\Message as ServiceMessage;
use ZendService\Google\Exception\RuntimeException as ServiceRuntimeException;

use InvalidArgumentException;

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
        return is_string($token) && $token != '';
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
                $this->response = $client->send($message);
            } catch (ServiceRuntimeException $e) {
                throw new PushException($e->getMessage());
            }

            if ((bool) $this->response->getSuccessCount()) {
                foreach ($tokensRange as $token) {
                    $pushedDevices->add($push->getDevices()->get($token));
                }
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
                    'adapter' => 'Zend\Http\Client\Adapter\Socket',
                    'sslverifypeer' => false
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
     */
    public function getServiceMessageFromOrigin(array $tokens, BaseOptionedModel $message)
    {
        $data            = $message->getOptions();
        $data['message'] = $message->getText();

        $serviceMessage = new ServiceMessage();
        $serviceMessage->setRegistrationIds($tokens);
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
            'collapse_key',
            'delay_while_idle',
            'time_to_live',
            'restricted_package_name',
            'dry_run'
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
