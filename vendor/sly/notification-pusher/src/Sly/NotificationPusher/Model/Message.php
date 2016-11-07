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
 * Message.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Message extends BaseOptionedModel implements MessageInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * Constructor.
     *
     * @param string $text    Text
     * @param array  $options Options
     */
    public function __construct($text, array $options = [])
    {
        $this->text    = $text;
        $this->options = $options;
    }

    /**
     * Get Text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set Text.
     *
     * @param string $text Text
     *
     * @return \Sly\NotificationPusher\Model\MessageInterface
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
