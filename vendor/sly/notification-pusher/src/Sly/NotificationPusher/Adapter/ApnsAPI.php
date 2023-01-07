<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 09.08.17
 * Time: 17:03
 */

namespace Sly\NotificationPusher\Adapter;


use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Model\PushInterface;

/**
 * @package Sly\Sly\NotificationPusher\Adapter
 * @author Oleg Abrazhaev <seyferseed@gmail.com>
 * todo: implement with edamov/pushok
 */
class ApnsAPI extends BaseAdapter
{

    /**
     * @param PushInterface $push Push
     *
     * @return DeviceCollection
     */
    public function push(PushInterface $push)
    {
        // TODO: Implement push() method.
    }

    /**
     * @param string $token Token
     *
     * @return boolean
     */
    public function supports($token)
    {
        // TODO: Implement supports() method.
    }

    /**
     * @return array
     */
    public function getDefinedParameters()
    {
        // TODO: Implement getDefinedParameters() method.
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        // TODO: Implement getDefaultParameters() method.
    }

    /**
     * @return array
     */
    public function getRequiredParameters()
    {
        // TODO: Implement getRequiredParameters() method.
    }
}
