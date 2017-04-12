<?php namespace LaravelFCM\Message;


use Illuminate\Contracts\Support\Arrayable;

/**
 * Class PayloadNotification
 *
 * @package LaravelFCM\Message
 */
class PayloadNotification implements Arrayable {

	/**
	 * @internal
	 * @var null|String
	 */
	protected $title;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $body;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $icon;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $sound;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $badge;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $tag;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $color;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $clickAction;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $bodyLocationKey;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $bodyLocationArgs;

	/**
	 * @internal
	 * @var null|String
	 */
	protected $titleLocationKey;

	/**
	 * @internal
	 * @var null|String
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
	 * convert PayloadNotification to array
	 *
	 * @return array
	 */
	function toArray()
	{
		$notification = [
			'title' => $this->title,
		    'body' => $this->body,
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