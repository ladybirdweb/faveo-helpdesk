<?php
/**
 * @see https://developers.podio.com/doc/search
 */
class PodioSearchResult extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('id', 'integer');
        $this->property('type', 'string');
        $this->property('rank', 'integer');
        $this->property('title', 'string');
        $this->property('created_on', 'datetime');
        $this->property('link', 'string');
        $this->property('app', 'hash');
        $this->property('org', 'hash');
        $this->property('space', 'hash');

        $this->has_one('created_by', 'ByLine');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/search/search-in-app-4234651
   */
  public static function app($app_id, $attributes = [])
  {
      return self::listing(Podio::post("/search/app/{$app_id}/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/search/search-in-space-22479
   */
  public static function space($space_id, $attributes = [])
  {
      return self::listing(Podio::post("/search/space/{$space_id}/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/search/search-in-organization-22487
   */
  public static function org($org_id, $attributes = [])
  {
      return self::listing(Podio::post("/search/org/{$org_id}/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/search/search-globally-22488
   */
  public static function search($attributes = [])
  {
      return self::listing(Podio::post('/search/', $attributes));
  }

  /**
   * Search in app and space. Only applicable to platform.
   */
  public static function search_app_and_space($space_id, $app_id, $attributes = [])
  {
      return self::listing(Podio::post("/search/app/{$app_id}/space/{$space_id}", $attributes));
  }
}
