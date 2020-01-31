<?php

namespace Bugsnag\Breadcrumbs;

use Countable;
use Iterator;

class Recorder implements Countable, Iterator
{
    /**
     * The maximum number of breadcrumbs to store.
     *
     * @var int
     */
    const MAX_ITEMS = 25;

    /**
     * The recorded breadcrumbs.
     *
     * @var \Bugsnag\Breadcrumbs\Breadcrumb[]
     */
    protected $breadcrumbs = [];

    /**
     * The head position.
     *
     * @var int
     */
    protected $head = 0;

    /**
     * The pointer position.
     *
     * @var int
     */
    protected $pointer = 0;

    /**
     * The iteration position.
     *
     * @var int
     */
    protected $position = 0;

    /**
     * Record a breadcrumb.
     *
     * We're recording a maximum of 25 breadcrumbs. Once we've recorded 25, we
     * start wrapping back around and replacing the earlier ones. In order to
     * indicate the start of the list, we advance a head pointer.
     *
     * @param \Bugsnag\Breadcrumbs\Breadcrumb $breadcrumb
     *
     * @return void
     */
    public function record(Breadcrumb $breadcrumb)
    {
        // advance the head by one if we've caught up
        if ($this->breadcrumbs && $this->pointer === $this->head) {
            $this->head = ($this->head + 1) % static::MAX_ITEMS;
        }

        // record the new breadcrumb
        $this->breadcrumbs[$this->pointer] = $breadcrumb;

        // advance the pointer so we set the next breadcrumb in the next slot
        $this->pointer = ($this->pointer + 1) % static::MAX_ITEMS;
    }

    /**
     * Clear all recorded breadcrumbs.
     *
     * @return void
     */
    public function clear()
    {
        $this->head = 0;
        $this->pointer = 0;
        $this->position = 0;
        $this->breadcrumbs = [];
    }

    /**
     * Get the number of stored breadcrumbs.
     *
     * @return int
     */
    public function count()
    {
        return count($this->breadcrumbs);
    }

    /**
     * Get the current item.
     *
     * @return \Bugsnag\Breadcrumbs\Breadcrumb
     */
    public function current()
    {
        return $this->breadcrumbs[($this->head + $this->position) % static::MAX_ITEMS];
    }

    /**
     * Get the current key.
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Advance the key position.
     *
     * @return void
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Rewind the key position.
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Is the current key position set?
     *
     * @return int
     */
    public function valid()
    {
        return $this->position < $this->count();
    }
}
