<?php

/*
 * This file is part of NotificationPusher.
 *
 * (c) 2013 Cédric Dugat <cedric@dugat.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\PushInterface;

/**
 * PushCollection.
 *
 * @uses \Sly\NotificationPusher\Collection\AbstractCollection
 * @uses \IteratorAggregate
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushCollection extends AbstractCollection
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->coll = new \ArrayIterator();
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return $this->coll;
    }

    /**
     * @param \Sly\NotificationPusher\Model\PushInterface $push Push
     */
    public function add(PushInterface $push)
    {
        $this->coll[] = $push;
    }
}
