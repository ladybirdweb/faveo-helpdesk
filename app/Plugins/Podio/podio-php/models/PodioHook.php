<?php
/**
 * @see https://developers.podio.com/doc/hooks
 */
class PodioHook extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('hook_id', 'integer', ['id' => true]);
        $this->property('status', 'string');
        $this->property('type', 'string');
        $this->property('url', 'string');
        $this->property('created_on', 'datetime');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('created_via', 'Via');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/hooks/get-hooks-215285
   */
  public static function get_for($ref_type, $ref_id)
  {
      return self::listing(Podio::get("/hook/{$ref_type}/{$ref_id}/"));
  }

  /**
   * @see https://developers.podio.com/doc/hooks/create-hook-215056
   */
  public static function create($ref_type, $ref_id, $attributes = [])
  {
      $body = Podio::post("/hook/{$ref_type}/{$ref_id}/", $attributes)->json_body();

      return $body['hook_id'];
  }

  /**
   * @see https://developers.podio.com/doc/hooks/request-hook-verification-215232
   */
  public static function verify($hook_id)
  {
      return Podio::post("/hook/{$hook_id}/verify/request")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/hooks/validate-hook-verification-215241
   */
  public static function validate($hook_id, $attributes = [])
  {
      return Podio::post("/hook/{$hook_id}/verify/validate", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/hooks/delete-hook-215291
   */
  public static function delete($hook_id)
  {
      return Podio::delete("/hook/{$hook_id}");
  }
}
