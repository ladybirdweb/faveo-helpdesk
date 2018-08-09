<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 10.08.17
 * Time: 10:30
 */

namespace Sly\NotificationPusher\Model;

use Sly\NotificationPusher\Collection\PushCollection;

interface ResponseInterface
{
    /**
     * @param DeviceInterface $device
     * @param array $response
     */
    public function addParsedResponse(DeviceInterface $device, $response);

    /**
     * @param DeviceInterface $device
     * @param mixed $originalResponse
     */
    public function addOriginalResponse(DeviceInterface $device, $originalResponse);

    /**
     * @param \Sly\NotificationPusher\Model\PushInterface $push Push
     */
    public function addPush(PushInterface $push);

    /**
     * @return array
     */
    public function getParsedResponses();

    /**
     * @return mixed
     */
    public function getOriginalResponses();

    /**
     * @return PushCollection
     */
    public function getPushCollection();
}