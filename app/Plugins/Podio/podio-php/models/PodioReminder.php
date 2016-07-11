<?php
/**
 * @see https://developers.podio.com/doc/reminders
 */
class PodioReminder extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('reminder_id', 'integer', ['id' => true]);
        $this->property('remind_delta', 'integer');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/reminders/get-reminder-3415569
   */
  public static function get_for($ref_type, $ref_id)
  {
      return self::member(Podio::get("/reminder/{$ref_type}/{$ref_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/reminders/create-or-update-reminder-3315055
   */
  public static function create($ref_type, $ref_id, $attributes = [])
  {
      return Podio::put("/reminder/{$ref_type}/{$ref_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/reminders/create-or-update-reminder-3315055
   */
  public static function update($ref_type, $ref_id, $attributes = [])
  {
      return Podio::put("/reminder/{$ref_type}/{$ref_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/reminders/snooze-reminder-3321049
   */
  public static function snooze($ref_type, $ref_id)
  {
      return Podio::post("/reminder/{$ref_type}/{$ref_id}/snooze");
  }

  /**
   * @see https://developers.podio.com/doc/reminders/delete-reminder-3315117
   */
  public static function delete($ref_type, $ref_id)
  {
      return Podio::delete("/reminder/{$ref_type}/{$ref_id}");
  }
}
