<?php
/**
 * @see https://developers.podio.com/doc/items
 */
class PodioItemRevision extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('revision', 'integer', ['id' => true]);
        $this->property('app_revision', 'integer');
        $this->property('created_on', 'datetime');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('created_via', 'Via');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/items/get-item-revision-22373
   */
  public static function get($item_id, $revision_id)
  {
      return self::member(Podio::get("/item/{$item_id}/revision/{$revision_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-revision-22373
   */
  public static function get_for($item_id)
  {
      return self::listing(Podio::get("/item/{$item_id}/revision/"));
  }
}
