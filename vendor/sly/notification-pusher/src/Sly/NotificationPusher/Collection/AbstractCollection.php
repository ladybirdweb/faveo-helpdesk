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

/**
 * AbstractCollection.
 *
 * @uses \IteratorAggregate
 * @author Cédric Dugat <cedric@dugat.me>
 */
abstract class AbstractCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var \ArrayIterator
     */
    protected $coll;

    /**
     * @inheritdoc
     * @return \ArrayIterator|\SeekableIterator
     */
    abstract public function getIterator();

    /**
     * Get.
     *
     * @param string $key Key
     *
     * @return \Sly\NotificationPusher\Model\MessageInterface|false
     */
    public function get($key)
    {
        return isset($this->coll[$key]) ? $this->coll[$key] : false;
    }

    /**
     * Count.
     *
     * @return integer
     */
    public function count()
    {
        return $this->getIterator()->count();
    }

    /**
     * isEmpty.
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * Clear categories.
     */
    public function clear()
    {
        $this->coll = new \ArrayIterator();
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        $tmp = clone $this->coll;

        //go to the beginning
        $tmp->rewind();

        if (!$tmp->valid()) {
            return null;
        }

        return $tmp->current();
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        $tmp = clone $this->coll;

        //go to the end
        $tmp->seek($tmp->count() - 1);

        if (!$tmp->valid()) {
            return null;
        }

        return $tmp->current();
    }
}
