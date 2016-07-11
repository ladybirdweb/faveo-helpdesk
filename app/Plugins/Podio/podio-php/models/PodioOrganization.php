<?php
/**
 * @see https://developers.podio.com/doc/organizations
 */
class PodioOrganization extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('org_id', 'integer', ['id' => true]);
        $this->property('name', 'string');
        $this->property('type', 'string');
        $this->property('logo', 'integer');
        $this->property('url', 'string');
        $this->property('user_limit', 'integer');
        $this->property('url_label', 'string');
        $this->property('premium', 'boolean');
        $this->property('role', 'string');
        $this->property('status', 'string');
        $this->property('sales_agent_id', 'integer');
        $this->property('created_on', 'datetime');
        $this->property('domains', 'array');
        $this->property('rights', 'array');
        $this->property('rank', 'integer');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('image', 'File');
        $this->has_many('spaces', 'Space');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/organizations/get-organization-22383
   */
  public static function get($org_id)
  {
      return self::member(Podio::get("/org/{$org_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/organizations/get-organization-by-url-22384
   */
  public static function get_for_url($attributes = [])
  {
      return self::member(Podio::get('/org/url', $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/organizations/get-organizations-22344
   */
  public static function get_all()
  {
      return self::listing(Podio::get('/org/'));
  }

  /**
   * @see https://developers.podio.com/doc/organizations/add-new-organization-22385
   */
  public static function create($attributes = [])
  {
      return self::member(Podio::post('/org/', $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/organizations/add-organization-admin-50854
   */
  public static function create_admin($org_id, $attributes = [])
  {
      return Podio::post("/org/{$org_id}/admin/", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/organizations/get-organization-admins-81542
   */
  public static function get_all_admins($org_id)
  {
      return PodioUser::listing(Podio::get("/org/{$org_id}/admin/"));
  }

  /**
   * @see https://developers.podio.com/doc/organizations/get-organization-login-report-51730
   */
  public static function get_login_report($org_id, $attributes = [])
  {
      return Podio::get("/org/{$org_id}/report/login", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/organizations/get-organization-statistics-28734
   */
  public static function get_statistics($org_id, $attributes = [])
  {
      return Podio::get("/org/{$org_id}/statistics", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/organizations/update-organization-22386
   */
  public static function update($org_id, $attributes = [])
  {
      return Podio::put("/org/{$org_id}", $attributes);
  }

  /**
   * Bootstrap organization. Only applicable on Podio Platform.
   */
  public static function bootstrap($attributes = [])
  {
      return Podio::post('/org/bootstrap', $attributes);
  }
}
