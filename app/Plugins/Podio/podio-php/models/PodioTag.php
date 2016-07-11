<?php
/**
 * @see https://developers.podio.com/doc/tags
 */
class PodioTag extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('count', 'integer');
        $this->property('text', 'string');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/tags/create-tags-22464
   */
  public static function create($ref_type, $ref_id, $attributes = [])
  {
      return Podio::post("/tag/{$ref_type}/{$ref_id}/", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/tags/update-tags-39859
   */
  public static function update($ref_type, $ref_id, $attributes = [])
  {
      return Podio::put("/tag/{$ref_type}/{$ref_id}/", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/tags/remove-tag-22465
   */
  public static function delete($ref_type, $ref_id, $attributes = [])
  {
      return Podio::delete("/tag/{$ref_type}/{$ref_id}/", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/tags/get-tags-on-app-22467
   */
  public static function get_for_app($app_id, $attributes = [])
  {
      return self::listing(Podio::get("/tag/app/{$app_id}/", $attributes));
  }
}
