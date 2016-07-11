<?php
/**
 * @see https://developers.podio.com/doc/spaces
 */
class PodioSpace extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('space_id', 'integer', ['id' => true]);
        $this->property('name', 'string');
        $this->property('url', 'string');
        $this->property('url_label', 'string');
        $this->property('org_id', 'integer');
        $this->property('contact_count', 'integer');
        $this->property('members', 'integer');
        $this->property('role', 'string');
        $this->property('rights', 'array');
        $this->property('post_on_new_app', 'boolean');
        $this->property('post_on_new_member', 'boolean');
        $this->property('subscribed', 'boolean');
        $this->property('privacy', 'string');
        $this->property('auto_join', 'boolean');
        $this->property('type', 'string');
        $this->property('premium', 'boolean');
        $this->property('description', 'string');

        $this->property('created_on', 'datetime');
        $this->property('last_activity_on', 'datetime');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('org', 'Organization');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/spaces/get-space-22389
   */
  public static function get($space_id)
  {
      return self::member(Podio::get("/space/{$space_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/organizations/get-spaces-on-organization-22387
   */
  public static function get_for_org($org_id)
  {
      return self::listing(Podio::get("/org/{$org_id}/space/"));
  }

  /**
   * @see https://developers.podio.com/doc/spaces/get-space-by-url-22481
   */
  public static function get_for_url($attributes = [])
  {
      return self::member(Podio::get('/space/url', $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/spaces/get-available-spaces-1911961
   */
  public static function get_available($org_id)
  {
      return self::listing(Podio::get("/space/org/{$org_id}/available/"));
  }

  /**
   * @see https://developers.podio.com/doc/spaces/get-top-spaces-22477
   */
  public static function get_top($attributes = [])
  {
      return self::listing(Podio::get('/space/top/', $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/spaces/create-space-22390
   */
  public static function create($attributes = [])
  {
      return Podio::post('/space/', $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/spaces/update-space-22391
   */
  public static function update($space_id, $attributes = [])
  {
      return Podio::put("/space/{$space_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/spaces/delete-space-22417
   */
  public static function delete($space_id, $attributes = [])
  {
      return Podio::delete("/space/{$space_id}");
  }
}
