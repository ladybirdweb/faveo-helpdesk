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

use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Model\PushInterface;
use Sly\NotificationPusher\Model\ResponseInterface;

/**
 * @author Cédric Dugat <cedric@dugat.me>
 */
interface AdapterInterface
{
    /**
     * @param PushInterface $push Push
     *
     * @return DeviceCollection
     */
    public function push(PushInterface $push);

    /**
     * @param string $token Token
     *
     * @return boolean
     */
    public function supports($token);

    /**
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response);

    /**
     * @return array
     */
    public function getDefinedParameters();

    /**
     * @return array
     */
    public function getDefaultParameters();

    /**
     * @return array
     */
    public function getRequiredParameters();

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @param string $environment Environment value to set
     *
     * @return AdapterInterface
     */
    public function setEnvironment($environment);
}
