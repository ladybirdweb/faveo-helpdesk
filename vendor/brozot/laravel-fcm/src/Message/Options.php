<?php

namespace LaravelFCM\Message;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Options.
 */
class Options implements Arrayable
{
    /**
     * @internal
     *
     * @var null|string
     */
    protected $collapseKey;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $priority;

    /**
     * @internal
     *
     * @var bool
     */
    protected $contentAvailable;

    /**
     * @internal
     *
     * @var bool
     */
    protected $isMutableContent = false;

    /**
     * @internal
     *
     * @var bool
     */
    protected $delayWhileIdle;

    /**
     * @internal
     *
     * @var int|null
     */
    protected $timeToLive;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $restrictedPackageName;

    /**
     * @internal
     *
     * @var bool
     */
    protected $isDryRun = false;

    /**
     * Options constructor.
     *
     * @param OptionsBuilder $builder
     */
    public function __construct(OptionsBuilder $builder)
    {
        $this->collapseKey = $builder->getCollapseKey();
        $this->priority = $builder->getPriority();
        $this->contentAvailable = $builder->isContentAvailable();
        $this->isMutableContent = $builder->isMutableContent();
        $this->delayWhileIdle = $builder->isDelayWhileIdle();
        $this->timeToLive = $builder->getTimeToLive();
        $this->restrictedPackageName = $builder->getRestrictedPackageName();
        $this->isDryRun = $builder->isDryRun();
    }

    /**
     * Transform Option to array.
     *
     * @return array
     */
    public function toArray()
    {
        $contentAvailable = $this->contentAvailable ? true : null;
        $mutableContent = $this->isMutableContent ? true : null;
        $delayWhileIdle = $this->delayWhileIdle ? true : null;
        $dryRun = $this->isDryRun ? true : null;

        $options = [
            'collapse_key' => $this->collapseKey,
            'priority' => $this->priority,
            'content_available' => $contentAvailable,
            'mutable_content' => $mutableContent,
            'delay_while_idle' => $delayWhileIdle,
            'time_to_live' => $this->timeToLive,
            'restricted_package_name' => $this->restrictedPackageName,
            'dry_run' => $dryRun,
        ];

        return array_filter($options);
    }
}
