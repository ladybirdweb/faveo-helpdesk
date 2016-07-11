<?php
/**
 * @see https://developers.podio.com/doc/users
 */
class PodioUserStatus extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('properties', 'hash');
        $this->property('inbox_new', 'integer');
        $this->property('calendar_code', 'string');
        $this->property('task_mail', 'string');
        $this->property('mailbox', 'string');

        $this->has_one('user', 'User');
        $this->has_one('profile', 'Contact');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/users/get-user-status-22480
   */
  public static function get()
  {
      return self::member(Podio::get('/user/status'));
  }
}
