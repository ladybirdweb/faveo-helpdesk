<?php
/**
 * @see https://developers.podio.com/doc/applications
 */
class PodioApp extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('app_id', 'integer', ['id' => true]);
        $this->property('original', 'integer');
        $this->property('original_revision', 'integer');
        $this->property('status', 'string');
        $this->property('icon', 'string');
        $this->property('icon_id', 'integer');
        $this->property('space_id', 'integer');
        $this->property('owner_id', 'integer');
        $this->property('owner', 'hash'); // TODO: User class?
    $this->property('config', 'hash');
        $this->property('subscribed', 'boolean');
        $this->property('rights', 'array');
        $this->property('link', 'string');
        $this->property('url_add', 'string');
        $this->property('token', 'string');
        $this->property('url_label', 'string');
        $this->property('mailbox', 'string');

        $this->has_one('integration', 'Integration');
        $this->has_many('fields', 'AppField');

    // When app is returned as part of large collection (e.g. for stream), some config properties is moved to the main object
    $this->property('name', 'string');
        $this->property('item_name', 'string');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/applications/get-app-22349
   */
  public static function get($app_id, $attributes = [])
  {
      return self::member(Podio::get("/app/{$app_id}", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-all-user-apps-5902728
   */
  public static function get_all($attributes = [])
  {
      return self::listing(Podio::get('/app/v2/', $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-top-apps-22476
   */
  public static function get_top($attributes = [])
  {
      return self::listing(Podio::get('/app/top/', $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-top-apps-for-organization-1671395
   */
  public static function get_top_for_org($org_id, $attributes = [])
  {
      return self::listing(Podio::get("/app/org/{$org_id}/top/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-app-on-space-by-url-label-477105
   */
  public static function get_for_url($space_id, $url_label, $attributes = [])
  {
      return self::member(Podio::get("/app/space/{$space_id}/{$url_label}", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-apps-by-space-22478
   */
  public static function get_for_space($space_id, $attributes = [])
  {
      return self::listing(Podio::get("/app/space/{$space_id}/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/applications/add-new-app-22351
   */
  public static function create($attributes = [])
  {
      return self::member(Podio::post('/app/', $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/applications/update-app-22352
   */
  public static function update($app_id, $attributes = [])
  {
      return Podio::put("/app/{$app_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/applications/delete-app-43693
   */
  public static function delete($app_id)
  {
      return Podio::delete("/app/{$app_id}");
  }

  /**
   * @see https://developers.podio.com/doc/applications/install-app-22506
   */
  public static function install($app_id, $attributes = [])
  {
      $body = Podio::post("/app/{$app_id}/install", $attributes)->json_body();

      return $body['app_id'];
  }

  /**
   * @see https://developers.podio.com/doc/applications/update-app-order-22463
   */
  public static function update_org($space_id, $attributes = [])
  {
      return Podio::put("/app/space/{$space_id}/order", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/applications/activate-app-43822
   */
  public static function activate($app_id)
  {
      return Podio::post("/app/{$app_id}/activate");
  }

  /**
   * @see https://developers.podio.com/doc/applications/deactivate-app-43821
   */
  public static function deactivate($app_id)
  {
      return Podio::post("/app/{$app_id}/deactivate");
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-calculations-for-app-773005
   */
  public static function calculations($app_id)
  {
      return self::listing(Podio::get("/app/{$app_id}/calculation/"));
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-features-43648
   */
  public static function features($attributes = [])
  {
      return Podio::get('/app/features/')->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-app-dependencies-39159
   */
  public static function dependencies($app_id)
  {
      $result = Podio::get("/app/{$app_id}/dependencies/")->json_body();
      $result['apps'] = self::listing($result['apps']);

      return $result;
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-space-app-dependencies-45779
   */
  public static function dependencies_space($space_id)
  {
      $result = Podio::get("/space/{$space_id}/dependencies/")->json_body();
      $result['apps'] = self::listing($result['apps']);

      return $result;
  }

  /**
   * Activate app in space. Only applicable to Platform.
   */
  public static function activate_for_space($app_id, $space_id, $attributes = [])
  {
      return Podio::put("/app/{$app_id}/activate/{$space_id}", $attributes);
  }
}
