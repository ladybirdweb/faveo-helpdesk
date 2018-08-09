<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 09.08.17
 * Time: 17:57
 */

namespace Sly\NotificationPusher\Model;


use Sly\NotificationPusher\Collection\PushCollection;

class Response implements ResponseInterface
{
    /**
     * @var array
     */
    private $parsedResponses = [];

    /**
     * @var array
     */
    private $originalResponses = [];

    /**
     * @var PushCollection
     */
    private $pushCollection;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->pushCollection = new PushCollection();
    }

    /**
     * @param DeviceInterface $device
     * @param array $response
     */
    public function addParsedResponse(DeviceInterface $device, $response)
    {
        if (!is_array($response)) {
            throw new \InvalidArgumentException('Response must be array type');
        }

        $this->parsedResponses[$device->getToken()] = $response;
    }

    /**
     * @param DeviceInterface $device
     * @param mixed $originalResponse
     */
    public function addOriginalResponse(DeviceInterface $device, $originalResponse)
    {
        $this->originalResponses[$device->getToken()] = $originalResponse;
    }

    /**
     * @param \Sly\NotificationPusher\Model\PushInterface $push Push
     */
    public function addPush(PushInterface $push)
    {
        $this->pushCollection->add($push);
    }

    /**
     * @return array
     */
    public function getParsedResponses()
    {
        return $this->parsedResponses;
    }

    /**
     * @return mixed
     */
    public function getOriginalResponses()
    {
        return $this->originalResponses;
    }

    /**
     * @return PushCollection
     */
    public function getPushCollection()
    {
        return $this->pushCollection;
    }
}