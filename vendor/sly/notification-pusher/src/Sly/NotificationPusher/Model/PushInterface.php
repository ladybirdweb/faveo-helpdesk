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
use Sly\NotificationPusher\Collection\ResponseCollection;

interface PushInterface
{
    /**
     * Constants define available statuses
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PUSHED = 'sent';

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status Status
     *
     * @return PushInterface
     */
    public function setStatus($status);

    /**
     * @return boolean
     */
    public function isPushed();

    /**
     * @return PushInterface
     */
    public function pushed();

    /**
     * @return AdapterInterface
     */
    public function getAdapter();

    /**
     * @param AdapterInterface $adapter Adapter
     *
     * @return PushInterface
     */
    public function setAdapter(AdapterInterface $adapter);

    /**
     * @return MessageInterface
     */
    public function getMessage();

    /**
     * @param MessageInterface $message Message
     *
     * @return PushInterface
     */
    public function setMessage(MessageInterface $message);

    /**
     * @return DeviceCollection
     */
    public function getDevices();

    /**
     * @param DeviceCollection $devices Devices
     *
     * @return PushInterface
     */
    public function setDevices(DeviceCollection $devices);

    /**
     * @return ResponseCollection
     */
    public function getResponses();

    /**
     * @param DeviceInterface $device
     * @param mixed $response
     */
    public function addResponse(DeviceInterface $device, $response);

    /**
     * @return DateTime
     */
    public function getPushedAt();

    /**
     * @param DateTime $pushedAt PushedAt
     *
     * @return PushInterface
     */
    public function setPushedAt(DateTime $pushedAt);
}
