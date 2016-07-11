<?php
/**
 * @see https://developers.podio.com/doc/recurrence
 */
class PodioRecurrence extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('recurrence_id', 'integer', ['id' => true]);
        $this->property('name', 'string');
        $this->property('config', 'hash');
        $this->property('step', 'integer');
        $this->property('until', 'date');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/recurrence/get-recurrence-3415545
   */
  public static function get_for($ref_type, $ref_id)
  {
      return self::member(Podio::get("/recurrence/{$ref_type}/{$ref_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/recurrence/create-or-update-recurrence-3349957
   */
  public static function create($ref_type, $ref_id, $attributes = [])
  {
      return Podio::put("/recurrence/{$ref_type}/{$ref_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/recurrence/create-or-update-recurrence-3349957
   */
  public static function update($ref_type, $ref_id, $attributes = [])
  {
      return Podio::put("/recurrence/{$ref_type}/{$ref_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/recurrence/delete-recurrence-3349970
   */
  public static function delete($ref_type, $ref_id)
  {
      return Podio::delete("/recurrence/{$ref_type}/{$ref_id}");
  }
}
