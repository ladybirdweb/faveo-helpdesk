<?php
/**
 * @see https://developers.podio.com/doc/widgets
 */
class PodioWidget extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('widget_id', 'integer', ['id' => true]);
        $this->property('type', 'string');
        $this->property('title', 'string');
        $this->property('config', 'hash');
        $this->property('rights', 'array');
        $this->property('data', 'hash'); // Only for get_for() method

    $this->has_one('created_by', 'ByLine');
        $this->property('created_on', 'datetime');
        $this->has_one('ref', 'Reference');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/widgets/create-widget-22491
   */
  public static function create($ref_type, $ref_id, $attributes = [])
  {
      return self::member(Podio::post("/widget/{$ref_type}/{$ref_id}/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/widgets/delete-widget-22492
   */
  public static function delete($widget_id)
  {
      return Podio::delete("/widget/{$widget_id}");
  }

  /**
   * @see https://developers.podio.com/doc/widgets/get-widget-22489
   */
  public static function get($widget_id)
  {
      return self::member(Podio::get("/widget/{$widget_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/widgets/get-widgets-22494
   */
  public static function get_for($ref_type, $ref_id)
  {
      return self::listing(Podio::get("/widget/{$ref_type}/{$ref_id}/"));
  }

  /**
   * @see https://developers.podio.com/doc/widgets/update-widget-22490
   */
  public static function update($widget_id, $attributes = [])
  {
      return Podio::put("/widget/{$widget_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/widgets/update-widget-order-22495
   */
  public static function update_order($ref_type, $ref_id, $attributes = [])
  {
      return Podio::put("/widget/{$ref_type}/{$ref_id}/order", $attributes);
  }
}
