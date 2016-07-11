<?php
/**
 * @see https://developers.podio.com/doc/applications
 */
class PodioAppField extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('field_id', 'integer', ['id' => true]);
        $this->property('type', 'string');
        $this->property('external_id', 'string');
        $this->property('config', 'hash');
        $this->property('status', 'string');
        $this->property('label', 'string');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/applications/add-new-app-field-22354
   */
  public static function create($app_id, $attributes = [])
  {
      $body = Podio::post("/app/{$app_id}/field/", $attributes)->json_body();

      return $body['field_id'];
  }

  /**
   * @see https://developers.podio.com/doc/applications/get-app-field-22353
   */
  public static function get($app_id, $field_id)
  {
      return self::member(Podio::get("/app/{$app_id}/field/{$field_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/applications/update-an-app-field-22356
   */
  public static function update($app_id, $field_id, $attributes = [])
  {
      return Podio::put("/app/{$app_id}/field/{$field_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/applications/delete-app-field-22355
   */
  public static function delete($app_id, $field_id, $attributes = [])
  {
      $body = Podio::delete("/app/{$app_id}/field/{$field_id}", $attributes)->json_body();

      return $body['revision'];
  }
}
