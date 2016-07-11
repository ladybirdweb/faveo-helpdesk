<?php
/**
 * @see https://developers.podio.com/doc/actions
 */
class PodioAction extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('action_id', 'integer', ['id' => true]);
        $this->property('type', 'string');
        $this->property('data', 'hash');
        $this->property('text', 'string');

        $this->has_many('comments', 'Comment');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/actions/get-action-1701120
   */
  public static function get($action_id)
  {
      return self::member(Podio::get("/action/{$action_id}"));
  }
}
