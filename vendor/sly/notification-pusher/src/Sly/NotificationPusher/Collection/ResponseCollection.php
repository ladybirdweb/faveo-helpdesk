<?php

/*
 * This file is part of NotificationPusher.
 *
 * (c) 2016 Lukas Klinzing <theluk@gmail.com>
 * (c) 2013 Cédric Dugat <cedric@dugat.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sly\NotificationPusher\Collection;

/**
 * Response Collection.
 * is just a container for a response from a push service
 *
 * @uses \Sly\NotificationPusher\Collection\AbstractCollection
 * @uses \IteratorAggregate
 * @author Lukas Klinzing <theluk@gmail.com>
 */
class ResponseCollection extends AbstractCollection
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
     * @param string $token
     * @param mixed $response
     */
    public function add($token, $response)
    {
        $this->coll[$token] = $response;
    }
}
