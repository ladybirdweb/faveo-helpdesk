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
 * MessageInterface
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
interface MessageInterface
{
    /**
     * Get Text.
     *
     * @return string
     */
    public function getText();

    /**
     * Set Text.
     *
     * @param string $text Text
     *
     * @return \Sly\NotificationPusher\Model\MessageInterface
     */
    public function setText($text);
}
