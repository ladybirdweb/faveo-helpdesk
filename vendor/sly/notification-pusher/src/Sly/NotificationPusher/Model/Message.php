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
class Message extends BaseOptionedModel implements MessageInterface
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @param string $text Text
     * @param array $options Options
     */
    public function __construct($text, array $options = [])
    {
        $this->text = $text;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text Text
     *
     * @return MessageInterface
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
