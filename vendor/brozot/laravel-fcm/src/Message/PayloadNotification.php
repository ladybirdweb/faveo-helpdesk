<?php

namespace LaravelFCM\Message;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class PayloadNotification.
 */
class PayloadNotification implements Arrayable
{
    /**
     * @internal
     *
     * @var null|string
     */
    protected $title;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $body;

    /**
     * @internal
     *
     * @var null/string
     */
    protected $channelId;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $icon;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $sound;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $badge;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $tag;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $color;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $clickAction;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $bodyLocationKey;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $bodyLocationArgs;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $titleLocationKey;

    /**
     * @internal
     *
     * @var null|string
     */
    protected $titleLocationArgs;

    /**
     * PayloadNotification constructor.
     *
     * @param PayloadNotificationBuilder $builder
     */
    public function __construct(PayloadNotificationBuilder $builder)
    {
        $this->title = $builder->getTitle();
        $this->body = $builder->getBody();
        $this->channelId = $builder->getChannelId();
        $this->icon = $builder->getIcon();
        $this->sound = $builder->getSound();
        $this->badge = $builder->getBadge();
        $this->tag = $builder->getTag();
        $this->color = $builder->getColor();
        $this->clickAction = $builder->getClickAction();
        $this->bodyLocationKey = $builder->getBodyLocationKey();
        $this->bodyLocationArgs = $builder->getBodyLocationArgs();
        $this->titleLocationKey = $builder->getTitleLocationKey();
        $this->titleLocationArgs = $builder->getTitleLocationArgs();
    }

    /**
     * convert PayloadNotification to array.
     *
     * @return array
     */
    public function toArray()
    {
        $notification = [
            'title' => $this->title,
            'body' => $this->body,
            'android_channel_id' => $this->channelId,
            'icon' => $this->icon,
            'sound' => $this->sound,
            'badge' => $this->badge,
            'tag' => $this->tag,
            'color' => $this->color,
            'click_action' => $this->clickAction,
            'body_loc_key' => $this->bodyLocationKey,
            'body_loc_args' => $this->bodyLocationArgs,
            'title_loc_key' => $this->titleLocationKey,
            'title_loc_args' => $this->titleLocationArgs,
        ];

        // remove null values
        $notification = array_filter($notification);

        return $notification;
    }
}
