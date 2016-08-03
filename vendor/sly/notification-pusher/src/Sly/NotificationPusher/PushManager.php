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

use Sly\NotificationPusher\Collection\PushCollection;
use Sly\NotificationPusher\Adapter\AdapterInterface;
use Sly\NotificationPusher\Exception\AdapterException;

/**
 * PushManager.
 *
 * @uses \Sly\NotificationPusher\Collection\PushCollection
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushManager extends PushCollection
{
    const ENVIRONMENT_DEV  = 'dev';
    const ENVIRONMENT_PROD = 'prod';

    /**
     * @var string
     */
    private $environment;

    /**
     * Constructor.
     *
     * @param string $environment Environment
     */
    public function __construct($environment = self::ENVIRONMENT_DEV)
    {
        parent::__construct();

        $this->environment = $environment;
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
     * @return \Sly\NotificationPusher\Collection\PushCollection
     */
    public function push()
    {
        foreach ($this as $push) {
            $adapter = $push->getAdapter();
            $adapter->setEnvironment($this->getEnvironment());

            if ($adapter->push($push)) {
                $push->pushed();
            }
        }

        return $this;
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
        if (false === method_exists($adapter, 'getFeedback')) {
            throw new AdapterException(
                sprintf(
                    '%s adapter has no dedicated "getFeedback" method',
                    (string) $adapter
                )
            );
        }

        return $adapter->getFeedback();
    }
}
