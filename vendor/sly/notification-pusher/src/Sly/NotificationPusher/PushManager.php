<?php

/*
 * This file is part of NotificationPusher.
 *
 * (c) 2013 Cédric Dugat <cedric@dugat.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sly\NotificationPusher;

use Sly\NotificationPusher\Adapter\AdapterInterface;
use Sly\NotificationPusher\Adapter\FeedbackAdapterInterface;
use Sly\NotificationPusher\Collection\PushCollection;
use Sly\NotificationPusher\Exception\AdapterException;
use Sly\NotificationPusher\Model\Push;
use Sly\NotificationPusher\Model\PushInterface;
use Sly\NotificationPusher\Model\ResponseInterface;

/**
 * PushManager.
 *
 * @uses \Sly\NotificationPusher\Collection\PushCollection
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushManager
{
    const ENVIRONMENT_DEV  = 'dev';
    const ENVIRONMENT_PROD = 'prod';

    /**
     * @var string
     */
    private $environment;

    /**
     * @var PushCollection
     */
    private $pushCollection;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * Constructor.
     *
     * @param string $environment Environment
     */
    public function __construct($environment = self::ENVIRONMENT_DEV)
    {
        $this->environment    = $environment;
        $this->pushCollection = new PushCollection();
    }

    /**
     * @param \Sly\NotificationPusher\Model\PushInterface $push Push
     */
    public function add(PushInterface $push)
    {
        $this->pushCollection->add($push);
    }

    /**
     * Get environment.
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Push.
     *
     * @return PushCollection
     */
    public function push()
    {
        /** @var Push $push */
        foreach ($this->pushCollection as $push) {
            $adapter = $push->getAdapter();
            $adapter->setEnvironment($this->getEnvironment());

            if ($adapter->push($push)) {
                $push->pushed();
            }
        }

        if ($this->pushCollection && !$this->pushCollection->isEmpty()) {
            /** @var Push $push */
            $push           = $this->pushCollection->first();
            $this->response = $push->getAdapter()->getResponse();
        }
        
        return $this->pushCollection;
    }

    /**
     * Get feedback.
     *
     * @param \Sly\NotificationPusher\Adapter\AdapterInterface $adapter Adapter
     *
     * @return array
     *
     * @throws AdapterException When the adapter has no dedicated `getFeedback` method
     */
    public function getFeedback(AdapterInterface $adapter)
    {
        if (!$adapter instanceof FeedbackAdapterInterface) {
            throw new AdapterException(
                sprintf(
                    '%s adapter has no dedicated "getFeedback" method',
                    (string)$adapter
                )
            );
        }
        $adapter->setEnvironment($this->getEnvironment());

        return $adapter->getFeedback();
    }

    /**
     * @return PushCollection
     */
    public function getPushCollection()
    {
        return $this->pushCollection;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
