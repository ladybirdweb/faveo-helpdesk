<?php

namespace LaravelFCM\Message;

use LaravelFCM\Message\Exceptions\InvalidOptionsException;
use ReflectionClass;

/**
 * Builder for creation of options used by FCM.
 *
 * Class OptionsBuilder
 *
 * @link http://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json
 */
class OptionsBuilder
{
    /**
     * @internal
     *
     * @var string
     */
    protected $collapseKey;

    /**
     * @internal
     *
     * @var string
     */
    protected $priority;

    /**
     * @internal
     *
     * @var bool
     */
    protected $contentAvailable = false;

    /**
     * @internal
     * @var bool
     */
    protected $mutableContent;

    /**
     * @internal
     *
     * @var bool
     */
    protected $delayWhileIdle = false;

    /**
     * @internal
     *
     * @var string
     */
    protected $timeToLive;

    /**
     * @internal
     *
     * @var string
     */
    protected $restrictedPackageName;

    /**
     * @internal
     *
     * @var bool
     */
    protected $dryRun = false;

    /**
     * This parameter identifies a group of messages
     * A maximum of 4 different collapse keys is allowed at any given time.
     *
     * @param string $collapseKey
     *
     * @return \LaravelFCM\Message\OptionsBuilder
     */
    public function setCollapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * Sets the priority of the message. Valid values are "normal" and "high."
     * By default, messages are sent with normal priority.
     *
     * @param string $priority
     *
     * @return \LaravelFCM\Message\OptionsBuilder
     *
     * @throws InvalidOptionsException
     * @throws \ReflectionException
     */
    public function setPriority($priority)
    {
        if (!OptionsPriorities::isValid($priority)) {
            throw new InvalidOptionsException('priority is not valid, please refer to the documentation or use the constants of the class "OptionsPriorities"');
        }
        $this->priority = $priority;

        return $this;
    }

    /**
     * support only Android and Ios.
     *
     * An inactive client app is awoken.
     * On iOS, use this field to represent content-available in the APNS payload.
     * On Android, data messages wake the app by default.
     * On Chrome, currently not supported.
     *
     * @param bool $contentAvailable
     *
     * @return \LaravelFCM\Message\OptionsBuilder
     */
    public function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;

        return $this;
    }

    /**
     * support iOS 10+
     *
     * When a notification is sent and this is set to true,
     * the content of the notification can be modified before it is displayed.
     *
     * @param String $isMutableContent
     * @return OptionsBuilder
     */
    public function setMutableContent($isMutableContent)
    {
        $this->mutableContent = $isMutableContent;

        return $this;
    }

    /**
     * When this parameter is set to true, it indicates that the message should not be sent until the device becomes active.
     *
     * @param bool $delayWhileIdle
     *
     * @return \LaravelFCM\Message\OptionsBuilder
     */
    public function setDelayWhileIdle($delayWhileIdle)
    {
        $this->delayWhileIdle = $delayWhileIdle;

        return $this;
    }

    /**
     * This parameter specifies how long the message should be kept in FCM storage if the device is offline.
     *
     * @param int $timeToLive (in second) min:0 max:2419200
     *
     * @return \LaravelFCM\Message\OptionsBuilder
     *
     * @throws InvalidOptionsException
     */
    public function setTimeToLive($timeToLive)
    {
        if ($timeToLive < 0 || $timeToLive > 2419200) {
            throw new InvalidOptionsException("time to live must be between 0 and 2419200, current value is: {$timeToLive}");
        }
        $this->timeToLive = $timeToLive;

        return $this;
    }

    /**
     * This parameter specifies the package name of the application where the registration tokens must match in order to receive the message.
     *
     * @param string $restrictedPackageName
     *
     * @return \LaravelFCM\Message\OptionsBuilder
     */
    public function setRestrictedPackageName($restrictedPackageName)
    {
        $this->restrictedPackageName = $restrictedPackageName;

        return $this;
    }

    /**
     * This parameter, when set to true, allows developers to test a request without actually sending a message.
     * It should only be used for the development.
     *
     * @param bool $isDryRun
     *
     * @return \LaravelFCM\Message\OptionsBuilder
     */
    public function setDryRun($isDryRun)
    {
        $this->dryRun = $isDryRun;

        return $this;
    }

    /**
     * Get the collapseKey.
     *
     * @return null|string
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * Get the priority.
     *
     * @return null|string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * is content available.
     *
     * @return bool
     */
    public function isContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
     * is mutable content
     *
     * @return bool
     */
    public function isMutableContent()
    {
        return $this->mutableContent;
    }

    /**
     * is delay white idle.
     *
     * @return bool
     */
    public function isDelayWhileIdle()
    {
        return $this->delayWhileIdle;
    }

    /**
     * get time to live.
     *
     * @return null|int
     */
    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    /**
     * get restricted package name.
     *
     * @return null|string
     */
    public function getRestrictedPackageName()
    {
        return $this->restrictedPackageName;
    }

    /**
     * is dry run.
     *
     * @return bool
     */
    public function isDryRun()
    {
        return $this->dryRun;
    }

    /**
     * build an instance of Options.
     *
     * @return Options
     */
    public function build()
    {
        return new Options($this);
    }
}

/**
 * Class OptionsPriorities.
 */
final class OptionsPriorities
{
    /**
     * @const high priority : iOS, these correspond to APNs priorities 10.
     */
    const high = 'high';

    /**
     * @const normal priority : iOS, these correspond to APNs priorities 5
     */
    const normal = 'normal';

    /**
     * @return array priorities available in fcm
     *
     * @throws \ReflectionException
     */
    public static function getPriorities()
    {
        $class = new ReflectionClass(__CLASS__);

        return $class->getConstants();
    }

    /**
     * check if this priority is supported by fcm.
     *
     * @param $priority
     *
     * @return bool
     *
     * @throws \ReflectionException
     */
    public static function isValid($priority)
    {
        return in_array($priority, static::getPriorities());
    }
}
