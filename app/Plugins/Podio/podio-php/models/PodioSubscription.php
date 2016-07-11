<?php
/**
 * @see https://developers.podio.com/doc/subscriptions
 */
class PodioSubscription extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('started_on', 'datetime');
        $this->property('notifications', 'integer');

        $this->has_one('ref', 'Reference');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/subscriptions/get-subscription-by-id-22446
   */
  public static function get($subscription_id)
  {
      return self::member(Podio::get("/subscription/{$subscription_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/subscriptions/get-subscription-by-reference-22408
   */
  public static function get_for($ref_type, $ref_id)
  {
      return self::member(Podio::get("/subscription/{$ref_type}/{$ref_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/subscriptions/subscribe-22409
   */
  public static function create($ref_type, $ref_id)
  {
      return Podio::post("/subscription/{$ref_type}/{$ref_id}")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/subscriptions/unsubscribe-by-id-22445
   */
  public static function delete($subscription_id)
  {
      return Podio::delete("/subscription/{$subscription_id}");
  }

  /**
   * @see https://developers.podio.com/doc/subscriptions/unsubscribe-by-reference-22410
   */
  public static function delete_for($ref_type, $ref_id)
  {
      return Podio::delete("/subscription/{$ref_type}/{$ref_id}");
  }
}
