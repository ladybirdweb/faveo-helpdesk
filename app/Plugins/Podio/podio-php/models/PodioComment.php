<?php
/**
 * @see https://developers.podio.com/doc/comments
 */
class PodioComment extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('comment_id', 'integer', ['id' => true]);
        $this->property('value', 'string');
        $this->property('rich_value', 'string');
        $this->property('external_id', 'integer');
        $this->property('space_id', 'integer');
        $this->property('created_on', 'datetime');
        $this->property('like_count', 'integer');
        $this->property('is_liked', 'boolean');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('created_via', 'Via');
        $this->has_one('ref', 'Reference');

        $this->has_one('embed', 'Embed', ['json_value' => 'embed_id', 'json_target' => 'embed_id']);
        $this->has_one('embed_file', 'File', ['json_value' => 'file_id', 'json_target' => 'embed_file_id']);
        $this->has_many('files', 'File', ['json_value' => 'file_id', 'json_target' => 'file_ids']);
        $this->has_many('questions', 'Question');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/comments/get-a-comment-22345
   */
  public static function get($comment_id)
  {
      return self::member(Podio::get("/comment/{$comment_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/comments/get-comments-on-object-22371
   */
  public static function get_for($ref_type, $ref_id, $attributes = [])
  {
      return self::listing(Podio::get("/comment/{$ref_type}/{$ref_id}/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/comments/delete-a-comment-22347
   */
  public static function delete($comment_id)
  {
      return Podio::delete("/comment/{$comment_id}");
  }

  /**
   * @see https://developers.podio.com/doc/comments/add-comment-to-object-22340
   */
  public static function create($ref_type, $ref_id, $attributes = [], $options = [])
  {
      $url = Podio::url_with_options("/comment/{$ref_type}/{$ref_id}", $options);
      $body = Podio::post($url, $attributes)->json_body();

      return $body['comment_id'];
  }

  /**
   * @see https://developers.podio.com/doc/comments/update-a-comment-22346
   */
  public static function update($comment_id, $attributes = [])
  {
      return Podio::put("/comment/{$comment_id}", $attributes);
  }
}
