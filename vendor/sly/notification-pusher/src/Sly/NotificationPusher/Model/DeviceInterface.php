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

/**
 * @author Cédric Dugat <cedric@dugat.me>
 */
interface DeviceInterface
{
    /**
     * @return string
     */
    public function getToken();

    /**
     * @param string $token Token
     *
     * @return DeviceInterface
     */
    public function setToken($token);
}
