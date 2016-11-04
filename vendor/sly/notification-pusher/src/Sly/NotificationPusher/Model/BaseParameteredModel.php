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
 * BaseParameteredModel.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
abstract class BaseParameteredModel
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Get parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Has parameter.
     *
     * @param string $key Key
     *
     * @return boolean
     */
    public function hasParameter($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * Get parameter.
     *
     * @param string $key     Key
     * @param mixed  $default Default
     *
     * @return mixed
     */
    public function getParameter($key, $default = null)
    {
        return $this->hasParameter($key) ? $this->parameters[$key] : $default;
    }

    /**
     * Set parameters.
     *
     * @param array $parameters Parameters
     *
     * @return \Sly\NotificationPusher\Model\BaseParameteredModel
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set parameter.
     *
     * @param string $key   Key
     * @param mixed  $value Value
     *
     * @return mixed
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $value;
    }
}
