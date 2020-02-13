<?php

/*
 * This file is part of NotificationPusher.
 *
 * (c) 2013 Cédric Dugat <cedric@dugat.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sly\NotificationPusher\Model;

use DateTime;
use Sly\NotificationPusher\Adapter\AdapterInterface;
use Sly\NotificationPusher\Collection\DeviceCollection;

/**
 * PushInterface
 */
interface PushInterface
{
    /**
     * Constants define available statuses
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PUSHED  = 'sent';

    /**
     * Get Status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set Status.
     *
     * @param string $status Status
     *
     * @return PushInterface
     */
    public function setStatus($status);

    /**
     * isPushed.
     *
     * @return boolean
     */
    public function isPushed();

    /**
     * Declare as pushed.
     *
     * @return PushInterface
     */
    public function pushed();

    /**
     * Get Adapter.
     *
     * @return AdapterInterface
     */
    public function getAdapter();

    /**
     * Set Adapter.
     *
     * @param AdapterInterface $adapter Adapter
     *
     * @return PushInterface
     */
    public function setAdapter(AdapterInterface $adapter);

    /**
     * Get Message.
     *
     * @return MessageInterface
     */
    public function getMessage();

    /**
     * Set Message.
     *
     * @param MessageInterface $message Message
     *
     * @return PushInterface
     */
    public function setMessage(MessageInterface $message);

    /**
     * Get Devices.
     *
     * @return DeviceCollection
     */
    public function getDevices();

    /**
     * Set Devices.
     *
     * @param DeviceCollection $devices Devices
     *
     * @return PushInterface
     */
    public function setDevices(DeviceCollection $devices);

    /**
     * Get Responses
     * @return \Sly\NotificationPusher\Collection\ResponseCollection
     */
    public function getResponses();

    /**
     * adds a response
     * @param \Sly\NotificationPusher\Model\DeviceInterface $device
     * @param mixed $response
     */
    public function addResponse(DeviceInterface $device, $response);

    /**
     * Get PushedAt.
     *
     * @return DateTime
     */
    public function getPushedAt();

    /**
     * Set PushedAt.
     *
     * @param DateTime $pushedAt PushedAt
     *
     * @return PushInterface
     */
    public function setPushedAt(DateTime $pushedAt);
}
