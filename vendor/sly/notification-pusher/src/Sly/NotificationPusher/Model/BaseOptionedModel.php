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
abstract class BaseOptionedModel
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $key Key
     *
     * @return boolean
     */
    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * @param string $key Key
     * @param mixed $default Default
     *
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return $this->hasOption($key) ? $this->options[$key] : $default;
    }

    /**
     * @param array $options Options
     *
     * @return BaseOptionedModel
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string $key Key
     * @param mixed $value Value
     *
     * @return mixed
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;

        return $value;
    }
}
