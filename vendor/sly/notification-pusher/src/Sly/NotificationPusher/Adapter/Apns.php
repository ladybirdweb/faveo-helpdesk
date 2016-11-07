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
use Sly\NotificationPusher\Model\DeviceInterface;
use Sly\NotificationPusher\Exception\AdapterException;
use Sly\NotificationPusher\Exception\PushException;
use Sly\NotificationPusher\Collection\DeviceCollection;

use ZendService\Apple\Apns\Client\AbstractClient as ServiceAbstractClient;
use ZendService\Apple\Apns\Client\Message as ServiceClient;
use ZendService\Apple\Apns\Message as ServiceMessage;
use ZendService\Apple\Apns\Message\Alert as ServiceAlert;
use ZendService\Apple\Apns\Response\Message as ServiceResponse;
use ZendService\Apple\Apns\Exception\RuntimeException as ServiceRuntimeException;
use ZendService\Apple\Apns\Client\Feedback as ServiceFeedbackClient;

/**
 * APNS adapter.
 *
 * @uses \Sly\NotificationPusher\Adapter\BaseAdapter
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Apns extends BaseAdapter
{

    /** @var ServiceClient */
    private $openedClient;

    /** @var ServiceFeedbackClient */
    private $feedbackClient;

    /**
     * {@inheritdoc}
     *
     * @throws \Sly\NotificationPusher\Exception\AdapterException
     */
    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);

        $cert = $this->getParameter('certificate');

        if (false === file_exists($cert)) {
            throw new AdapterException(sprintf('Certificate %s does not exist', $cert));
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Sly\NotificationPusher\Exception\PushException
     */
    public function push(PushInterface $push)
    {
        $client = $this->getOpenedServiceClient();

        $pushedDevices = new DeviceCollection();

        foreach ($push->getDevices() as $device) {
            $message = $this->getServiceMessageFromOrigin($device, $push->getMessage());

            try {
                $this->response = $client->send($message);
            } catch (ServiceRuntimeException $e) {
                throw new PushException($e->getMessage());
            }

            if (ServiceResponse::RESULT_OK === $this->response->getCode()) {
                $pushedDevices->add($device);
            }
        }

        return $pushedDevices;
    }

    /**
     * Feedback.
     *
     * @return array
     */
    public function getFeedback()
    {
        $client           = $this->getOpenedFeedbackClient();
        $responses        = [];
        $serviceResponses = $client->feedback();

        foreach ($serviceResponses as $response) {
            $responses[$response->getToken()] = new \DateTime(date('c', $response->getTime()));
        }

        return $responses;
    }

    /**
     * Get opened client.
     *
     * @param \ZendService\Apple\Apns\Client\AbstractClient $client Client
     *
     * @return \ZendService\Apple\Apns\Client\AbstractClient
     */
    public function getOpenedClient(ServiceAbstractClient $client)
    {
        $client->open(
            $this->isProductionEnvironment() ? ServiceClient::PRODUCTION_URI : ServiceClient::SANDBOX_URI,
            $this->getParameter('certificate'),
            $this->getParameter('passPhrase')
        );

        return $client;
    }

    /**
     * Get opened ServiceClient
     *
     * @return ServiceAbstractClient
     */
    private function getOpenedServiceClient()
    {
        if (!isset($this->openedClient)) {
            $this->openedClient = $this->getOpenedClient(new ServiceClient());
        }

        return $this->openedClient;
    }

    /**
     * Get opened ServiceFeedbackClient
     *
     * @return ServiceAbstractClient
     */
    private function getOpenedFeedbackClient()
    {
        if (!isset($this->feedbackClient)) {
            $this->feedbackClient = $this->getOpenedClient(new ServiceFeedbackClient());
        }

        return $this->feedbackClient;
    }

    /**
     * Get service message from origin.
     *
     * @param \Sly\NotificationPusher\Model\DeviceInterface $device Device
     * @param BaseOptionedModel|\Sly\NotificationPusher\Model\MessageInterface $message Message
     *
     * @return \ZendService\Apple\Apns\Message
     */
    public function getServiceMessageFromOrigin(DeviceInterface $device, BaseOptionedModel $message)
    {
        $badge = ($message->hasOption('badge'))
            ? (int) ($message->getOption('badge') + $device->getParameter('badge', 0))
            : false
        ;

        $sound = $message->getOption('sound', 'bingbong.aiff');
        $contentAvailable = $message->getOption('content-available');
        $category = $message->getOption('category');

        $alert = new ServiceAlert(
            $message->getText(),
            $message->getOption('actionLocKey'),
            $message->getOption('locKey'),
            $message->getOption('locArgs'),
            $message->getOption('launchImage'),
            $message->getOption('title'),
            $message->getOption('titleLocKey'),
            $message->getOption('titleLocArgs')
        );
        if ($actionLocKey = $message->getOption('actionLocKey')) {
            $alert->setActionLocKey($actionLocKey);
        }
        if ($locKey = $message->getOption('locKey')) {
            $alert->setLocKey($locKey);
        }
        if ($locArgs = $message->getOption('locArgs')) {
            $alert->setLocArgs($locArgs);
        }
        if ($launchImage = $message->getOption('launchImage')) {
            $alert->setLaunchImage($launchImage);
        }
        if ($title = $message->getOption('title')) {
            $alert->setTitle($title);
        }
        if ($titleLocKey = $message->getOption('titleLocKey')) {
            $alert->setTitleLocKey($titleLocKey);
        }
        if ($titleLocArgs = $message->getOption('titleLocArgs')) {
            $alert->setTitleLocArgs($titleLocArgs);
        }

        $serviceMessage = new ServiceMessage();
        $serviceMessage->setId(sha1($device->getToken().$message->getText()));
        $serviceMessage->setAlert($alert);
        $serviceMessage->setToken($device->getToken());
        if (false !== $badge) {
            $serviceMessage->setBadge($badge);
        }
        $serviceMessage->setCustom($message->getOption('custom', []));

        if (null !== $sound) {
            $serviceMessage->setSound($sound);
        }

        if (null !== $contentAvailable) {
            $serviceMessage->setContentAvailable($contentAvailable);
        }

        if (null !== $category) {
            $serviceMessage->setCategory($category);
        }

        return $serviceMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($token)
    {
        return (ctype_xdigit($token) && 64 == strlen($token));
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinedParameters()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return ['passPhrase' => null];
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredParameters()
    {
        return ['certificate'];
    }
}
