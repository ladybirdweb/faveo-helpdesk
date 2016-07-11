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

use Sly\NotificationPusher\Model\PushInterface;
use Sly\NotificationPusher\Model\MessageInterface;
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
 * @uses \Sly\NotificationPusher\Adapter\AdapterInterface
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Gcm extends BaseAdapter implements AdapterInterface
{
    /**
     * @var \Zend\Http\Client
     */
    private $httpClient;
    
    /**
     * {@inheritdoc}
     */
    public function supports($token)
    {
        return (bool) preg_match('/[0-9a-zA-Z\-\_]/i', $token);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Sly\NotificationPusher\Exception\PushException
     */
    public function push(PushInterface $push)
    {
        $client        = $this->getOpenedClient(new ServiceClient());
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
     * @param \ZendService\Google\Gcm\Client $client Client
     *
     * @return \ZendService\Google\Gcm\Client
     */
    public function getOpenedClient(ServiceClient $client)
    {
        $client->setApiKey($this->getParameter('apiKey'));
        
        if ($this->httpClient !== null) {
            $client->setHttpClient($this->httpClient);
        }

        return $client;
    }

    /**
     * Get service message from origin.
     *
     * @param array                                 $tokens  Tokens
     * @param \Sly\NotificationPusher\Model\MessageInterface $message Message
     *
     * @return \ZendService\Google\Gcm\Message
     */
    public function getServiceMessageFromOrigin(array $tokens, MessageInterface $message)
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
    public function getDefaultParameters()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredParameters()
    {
        return array('apiKey');
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
    public function setAdapterParameters(array $config = array())
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
