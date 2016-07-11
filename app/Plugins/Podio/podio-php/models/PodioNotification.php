<?php
/**
 * @see https://developers.podio.com/doc/notifications
 */
class PodioNotification extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('notification_id', 'integer', ['id' => true]);
        $this->property('type', 'string');
        $this->property('data', 'hash');
        $this->property('icon', 'string');
        $this->property('text', 'string');
        $this->property('viewed_on', 'datetime');
        $this->property('subscription_id', 'integer');
        $this->property('created_on', 'datetime');
        $this->property('starred', 'boolean');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('created_via', 'Via');
        $this->has_one('user', 'User');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/notifications/get-inbox-new-count-84610
   */
  public static function get_new_count()
  {
      $body = Podio::get('/notification/inbox/new/count')->json_body();

      return $body['new'];
  }

  /**
   * @see https://developers.podio.com/doc/notifications/mark-all-notifications-as-viewed-58099
   */
  public static function mark_all_as_viewed()
  {
      return Podio::post('/notification/viewed');
  }

  /**
   * @see https://developers.podio.com/doc/notifications/mark-notification-as-viewed-22436
   */
  public static function mark_as_viewed($notification_id)
  {
      return Podio::post("/notification/{$notification_id}/viewed");
  }

  /**
   * @see https://developers.podio.com/doc/notifications/mark-notifications-as-viewed-by-ref-553653
   */
  public static function mark_as_viewed_for_ref($ref_type, $ref_id)
  {
      return Podio::post("/notification/{$ref_type}/{$ref_id}/viewed");
  }

  /**
   * @see https://developers.podio.com/doc/notifications/star-notification-295910
   */
  public static function star($notification_id)
  {
      return Podio::post("/notification/{$notification_id}/star");
  }

  /**
   * @see https://developers.podio.com/doc/notifications/un-star-notification-295911
   */
  public static function unstar($notification_id)
  {
      return Podio::delete("/notification/{$notification_id}/star");
  }
}
