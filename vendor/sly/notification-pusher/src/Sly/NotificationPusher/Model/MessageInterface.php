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
interface MessageInterface
{
    /**
     * @return string
     */
    public function getText();

    /**
     * @param string $text Text
     *
     * @return MessageInterface
     */
    public function setText($text);
}
