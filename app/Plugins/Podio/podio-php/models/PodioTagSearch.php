<?php
/**
 * @see https://developers.podio.com/doc/tags
 */
class PodioTagSearch extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('id', 'integer');
        $this->property('type', 'string');
        $this->property('title', 'string');
        $this->property('link', 'string');
        $this->property('created_on', 'datetime');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/tags/get-objects-on-app-with-tag-22469
   */
  public static function get_for_app($app_id, $attributes = [])
  {
      return self::listing(Podio::get("/tag/app/{$app_id}/search/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/tags/get-objects-on-space-with-tag-22468
   */
  public static function get_for_space($space_id, $attributes = [])
  {
      return self::listing(Podio::get("/tag/space/{$space_id}/search/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/tags/get-objects-on-organization-with-tag-48478
   */
  public static function get_for_org($org_id, $attributes = [])
  {
      return self::listing(Podio::get("/tag/org/{$org_id}/search/", $attributes));
  }
}
