<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 09.08.17
 * Time: 17:03
 */

namespace Sly\Sly\NotificationPusher\Adapter;


use Sly\NotificationPusher\Adapter\BaseAdapter;
use Sly\NotificationPusher\Model\PushInterface;

/**
 * Class ApnsAPI
 * @package Sly\Sly\NotificationPusher\Adapter
 *
 * todo: implement with edamov/pushok
 */
class ApnsAPI extends BaseAdapter
{

    /**
     * Push.
     *
     * @param \Sly\NotificationPusher\Model\PushInterface $push Push
     *
     * @return \Sly\NotificationPusher\Collection\DeviceCollection
     */
    public function push(PushInterface $push)
    {
        // TODO: Implement push() method.
    }

    /**
     * Supports.
     *
     * @param string $token Token
     *
     * @return boolean
     */
    public function supports($token)
    {
        // TODO: Implement supports() method.
    }

    /**
     * Get defined parameters.
     *
     * @return array
     */
    public function getDefinedParameters()
    {
        // TODO: Implement getDefinedParameters() method.
    }

    /**
     * Get default parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        // TODO: Implement getDefaultParameters() method.
    }

    /**
     * Get required parameters.
     *
     * @return array
     */
    public function getRequiredParameters()
    {
        // TODO: Implement getRequiredParameters() method.
    }
}