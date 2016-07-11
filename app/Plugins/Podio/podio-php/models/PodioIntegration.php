<?php
/**
 * @see https://developers.podio.com/doc/integrations
 */
class PodioIntegration extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('integration_id', 'integer', ['id' => true]);
        $this->property('app_id', 'integer');
        $this->property('status', 'string');
        $this->property('type', 'string');
        $this->property('silent', 'boolean');
        $this->property('config', 'hash');
        $this->property('mapping', 'hash');
        $this->property('updating', 'boolean');
        $this->property('last_updated_on', 'datetime');
        $this->property('created_on', 'datetime');

        $this->has_one('created_by', 'ByLine');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/integrations/create-integration-86839
   */
  public static function create($app_id, $attributes = [])
  {
      $body = Podio::post("/integration/{$app_id}", $attributes)->json_body();

      return $body['integration_id'];
  }

  /**
   * @see https://developers.podio.com/doc/integrations/get-integration-86821
   */
  public static function get($app_id)
  {
      return self::member(Podio::get("/integration/{$app_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/integrations/refresh-integration-86987
   */
  public static function refresh($app_id)
  {
      return Podio::post("/integration/{$app_id}/refresh");
  }

  /**
   * @see https://developers.podio.com/doc/integrations/update-integration-86843
   */
  public static function update($app_id, $attributes = [])
  {
      return Podio::put("/integration/{$app_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/integrations/delete-integration-86876
   */
  public static function delete($app_id)
  {
      return Podio::delete("/integration/{$app_id}");
  }
}
