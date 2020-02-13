<?php

namespace Sly\NotificationPusher\Model;


class GcmMessage extends Message
{
    /**
     * @var array
     */
    private $notificationData = [];

    /**
     * @return array
     */
    public function getNotificationData()
    {
        return $this->notificationData;
    }

    /**
     * @param array $notificationData
     */
    public function setNotificationData($notificationData)
    {
        $this->notificationData = $notificationData;
    }
}