<?php
/**
 * @see https://developers.podio.com/doc/status
 */
class PodioStatus extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('status_id', 'integer', ['id' => true]);
        $this->property('value', 'string');
        $this->property('rich_value', 'string');
        $this->property('link', 'string');
        $this->property('ratings', 'hash');
        $this->property('subscribed', 'boolean');
        $this->property('user_ratings', 'hash');
        $this->property('created_on', 'datetime');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('created_via', 'Via');
        $this->has_one('embed', 'Embed', ['json_value' => 'embed_id', 'json_target' => 'embed_id']);
        $this->has_one('embed_file', 'File', ['json_value' => 'file_id', 'json_target' => 'embed_file_id']);
        $this->has_many('comments', 'Comment');
        $this->has_many('conversations', 'Conversation');
        $this->has_many('tasks', 'Task');
        $this->has_many('shares', 'AppMarketShare');
        $this->has_many('files', 'File', ['json_value' => 'file_id', 'json_target' => 'file_ids']);
        $this->has_many('questions', 'Question');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/status/add-new-status-message-22336
   */
  public static function create($space_id, $attributes = [])
  {
      return self::member(Podio::post("/status/space/{$space_id}/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/status/get-status-message-22337
   */
  public static function get($status_id)
  {
      return self::member(Podio::get("/status/{$status_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/status/delete-a-status-message-22339
   */
  public static function delete($status_id)
  {
      return Podio::delete("/status/{$status_id}");
  }
}
