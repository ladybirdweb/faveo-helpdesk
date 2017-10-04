<?php
/**
 * Zend Framework (http://framework.zend.com/).
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 *
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 *
 * @category  ZendService
 */
namespace ZendService\Google\Gcm;

use ZendService\Google\Exception;
use Zend\Json\Json;

/**
 * Google Cloud Messaging Message
 * This class defines a message to be sent
 * through the Google Cloud Messaging API.
 *
 * @category   ZendService
 */
class Message
{
    /**
     * @var array
     */
    protected $registrationIds = [];

    /**
     * @var string
     */
    protected $collapseKey;

    /**
     * @var string
     */
    protected $priority = 'normal';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $notification = [];

    /**
     * @var bool
     */
    protected $delayWhileIdle = false;

    /**
     * @var int
     */
    protected $timeToLive = 2419200;

    /**
     * @var string
     */
    protected $restrictedPackageName;

    /**
     * @var bool
     */
    protected $dryRun = false;

    /**
     * Set Registration Ids.
     *
     * @param array $ids
     *
     * @throws \ZendService\Google\Exception\InvalidArgumentException
     *
     * @return Message
     */
    public function setRegistrationIds(array $ids)
    {
        $this->clearRegistrationIds();
        foreach ($ids as $id) {
            $this->addRegistrationId($id);
        }

        return $this;
    }

    /**
     * Get Registration Ids.
     *
     * @return array
     */
    public function getRegistrationIds()
    {
        return $this->registrationIds;
    }

    /**
     * Add Registration Ids.
     *
     * @param string $id
     *
     * @return Message
     *
     * @throws Exception\InvalidArgumentException
     */
    public function addRegistrationId($id)
    {
        if (!is_string($id) || empty($id)) {
            throw new Exception\InvalidArgumentException('$id must be a non-empty string');
        }
        if (!in_array($id, $this->registrationIds)) {
            $this->registrationIds[] = $id;
        }

        return $this;
    }

    /**
     * Clear Registration Ids.
     *
     * @return Message
     */
    public function clearRegistrationIds()
    {
        $this->registrationIds = [];

        return $this;
    }

    /**
     * Get Collapse Key.
     *
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * Set Collapse Key.
     *
     * @param string $key
     *
     * @return Message
     *
     * @throws Exception\InvalidArgumentException
     */
    public function setCollapseKey($key)
    {
        if (null !== $key && !(is_string($key) && strlen($key) > 0)) {
            throw new Exception\InvalidArgumentException('$key must be null or a non-empty string');
        }
        $this->collapseKey = $key;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set priority
     *
     * @param string $priority
     * @return Message
     * @throws Exception\InvalidArgumentException
     */
    public function setPriority($priority)
    {
        if (!is_null($priority) && !(is_string($priority) && strlen($priority) > 0)) {
            throw new Exception\InvalidArgumentException('$priority must be null or a non-empty string');
        }
        $this->priority = $priority;
        return $this;
    }

    /**
     * Set Data
     *
     * @param array $data
     *
     * @throws \ZendService\Google\Exception\InvalidArgumentException
     *
     * @return Message
     */
    public function setData(array $data)
    {
        $this->clearData();
        foreach ($data as $k => $v) {
            $this->addData($k, $v);
        }

        return $this;
    }

    /**
     * Get Data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Add Data.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @throws Exception\RuntimeException
     * @throws Exception\InvalidArgumentException
     *
     * @return Message
     */
    public function addData($key, $value)
    {
        if (!is_string($key) || empty($key)) {
            throw new Exception\InvalidArgumentException('$key must be a non-empty string');
        }
        if (array_key_exists($key, $this->data)) {
            throw new Exception\RuntimeException('$key conflicts with current set data');
        }
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Clear Data.
     *
     * @return Message
     */
    public function clearData()
    {
        $this->data = [];

        return $this;
    }

    /**
     * Set notification
     *
     * @param array $data
     * @return Message
     */
    public function setNotification(array $data)
    {
        $this->clearNotification();
        foreach ($data as $k => $v) {
            $this->addNotification($k, $v);
        }
        return $this;
    }

    /**
     * Get notification
     *
     * @return array
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Add notification data
     *
     * @param string $key
     * @param mixed $value
     * @return Message
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    public function addNotification($key, $value)
    {
        if (!is_string($key) || empty($key)) {
            throw new Exception\InvalidArgumentException('$key must be a non-empty string');
        }
        if (array_key_exists($key, $this->notification)) {
            throw new Exception\RuntimeException('$key conflicts with current set data');
        }
        $this->notification[$key] = $value;
        return $this;
    }

    /**
     * Clear notification
     *
     * @return Message
     */
    public function clearNotification()
    {
        $this->notification = [];

        return $this;
    }

    /**
     * Set Delay While Idle
     *
     * @param bool $delay
     *
     * @return Message
     */
    public function setDelayWhileIdle($delay)
    {
        $this->delayWhileIdle = (bool) $delay;

        return $this;
    }

    /**
     * Get Delay While Idle.
     *
     * @return bool
     */
    public function getDelayWhileIdle()
    {
        return $this->delayWhileIdle;
    }

    /**
     * Set Time to Live.
     *
     * @param int $ttl
     *
     * @return Message
     */
    public function setTimeToLive($ttl)
    {
        $this->timeToLive = (int) $ttl;

        return $this;
    }

    /**
     * Get Time to Live.
     *
     * @return int
     */
    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    /**
     * Set Restricted Package Name.
     *
     * @param string $name
     *
     * @return Message
     *
     * @throws Exception\InvalidArgumentException
     */
    public function setRestrictedPackageName($name)
    {
        if (null !== $name && !(is_string($name) && strlen($name) > 0)) {
            throw new Exception\InvalidArgumentException('$name must be null OR a non-empty string');
        }
        $this->restrictedPackageName = $name;

        return $this;
    }

    /**
     * Get Restricted Package Name.
     *
     * @return string
     */
    public function getRestrictedPackageName()
    {
        return $this->restrictedPackageName;
    }

    /**
     * Set Dry Run.
     *
     * @param bool $dryRun
     *
     * @return Message
     */
    public function setDryRun($dryRun)
    {
        $this->dryRun = (bool) $dryRun;

        return $this;
    }

    /**
     * Get Dry Run.
     *
     * @return bool
     */
    public function getDryRun()
    {
        return $this->dryRun;
    }

    /**
     * To JSON
     * Utility method to put the JSON into the
     * GCM proper format for sending the message.
     *
     * @return string
     */
    public function toJson()
    {
        $json = [];
        if ($this->registrationIds) {
            $json['registration_ids'] = $this->registrationIds;
        }
        if ($this->collapseKey) {
            $json['collapse_key'] = $this->collapseKey;
        }
        if ($this->priority) {
            $json['priority'] = $this->priority;
        }
        if ($this->data) {
            $json['data'] = $this->data;
        }
        if ($this->notification) {
            $json['notification'] = $this->notification;
        }
        if ($this->delayWhileIdle) {
            $json['delay_while_idle'] = $this->delayWhileIdle;
        }
        if ($this->timeToLive != 2419200) {
            $json['time_to_live'] = $this->timeToLive;
        }
        if ($this->restrictedPackageName) {
            $json['restricted_package_name'] = $this->restrictedPackageName;
        }
        if ($this->dryRun) {
            $json['dry_run'] = $this->dryRun;
        }

        return Json::encode($json);
    }
}
