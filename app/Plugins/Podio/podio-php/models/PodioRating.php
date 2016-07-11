<?php
/**
 * @see https://developers.podio.com/doc/ratings
 */
class PodioRating extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('rating_id', 'integer', ['id' => true]);
        $this->property('type', 'string');
        $this->property('value', 'string');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/ratings/get-rating-22407
   */
  public static function get_for_type_and_user($ref_type, $ref_id, $rating_type, $user_id)
  {
      return self::member(Podio::get("/rating/{$ref_type}/{$ref_id}/{$rating_type}/{$user_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/ratings/get-ratings-22375
   */
  public static function get_for_type($ref_type, $ref_id, $rating_type)
  {
      return Podio::get("/rating/{$ref_type}/{$ref_id}/{$rating_type}")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/ratings/get-all-ratings-22376
   */
  public static function get_for($ref_type, $ref_id)
  {
      return Podio::get("/rating/{$ref_type}/{$ref_id}")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/ratings/get-rating-own-84128
   */
  public static function get_own_for_type($ref_type, $ref_id, $rating_type)
  {
      return self::member(Podio::get("/rating/{$ref_type}/{$ref_id}/{$rating_type}/self"));
  }

  /**
   * @see https://developers.podio.com/doc/ratings/add-rating-22377
   */
  public static function create($ref_type, $ref_id, $rating_type, $attributes = [])
  {
      return Podio::post("/rating/{$ref_type}/{$ref_id}/{$rating_type}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/ratings/remove-rating-22342
   */
  public static function delete($ref_type, $ref_id, $rating_type)
  {
      return Podio::delete("/rating/{$ref_type}/{$ref_id}/{$rating_type}");
  }
}
