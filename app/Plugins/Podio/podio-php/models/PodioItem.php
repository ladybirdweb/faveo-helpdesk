<?php
/**
 * @see https://developers.podio.com/doc/items
 */
class PodioItem extends PodioObject
{
    public function __construct($attributes = [])
    {

    // Basic item
    $this->property('item_id', 'integer', ['id' => true]);
        $this->property('external_id', 'string');
        $this->property('title', 'string');
        $this->property('link', 'string');
        $this->property('rights', 'array');
        $this->property('created_on', 'datetime');
        $this->property('app_item_id_formatted', 'string');
        $this->property('app_item_id', 'integer');

        $this->has_one('created_by', 'ByLine');
        $this->has_one('created_via', 'Via');

        $this->has_one('initial_revision', 'ItemRevision');
        $this->has_one('current_revision', 'ItemRevision');
        $this->has_many('fields', 'ItemField');

        $this->property('like_count', 'integer');
        $this->property('is_liked', 'boolean');

    // Extra properties for full item
    $this->property('ratings', 'hash');
        $this->property('user_ratings', 'hash');
        $this->property('last_event_on', 'datetime');
        $this->property('participants', 'hash');
        $this->property('tags', 'array');
        $this->property('refs', 'array');
        $this->property('references', 'array');
        $this->property('linked_account_id', 'integer');
        $this->property('subscribed', 'boolean');
        $this->property('invite', 'hash');
        $this->property('votes', 'hash');

        $this->has_one('app', 'App');
        $this->has_one('ref', 'Reference');
        $this->has_one('reminder', 'Reminder');
        $this->has_one('recurrence', 'Recurrence');
        $this->has_one('linked_account_data', 'LinkedAccountData');
        $this->has_many('comments', 'Comment');
        $this->has_many('revisions', 'ItemRevision');
        $this->has_many('files', 'File', ['json_value' => 'file_id', 'json_target' => 'file_ids']);
        $this->has_many('tasks', 'Task');
        $this->has_many('shares', 'AppMarketShare');

    // When getting item collection
    $this->property('comment_count', 'integer');
        $this->property('task_count', 'integer');

        $this->init($attributes);
    }

  /**
   * Create or updates an item.
   */
  public function save($options = [])
  {
      $json_attributes = $this->as_json_without_readonly_fields();

      if ($this->id) {
          return self::update($this->id, $json_attributes, $options);
      } else {
          if ($this->app && $this->app->id) {
              $new = self::create($this->app->id, $json_attributes, $options);
              $this->item_id = $new->item_id;

              return $this;
          } else {
              throw new PodioMissingRelationshipError('{"error_description":"Item is missing relationship to app"}', null, null);
          }
      }
  }

  /**
   * Return json representation without readonly fields. Used for saving items.
   */
  public function as_json_without_readonly_fields()
  {
      $readonly_fields = $this->fields->readonly_fields()->external_ids();
      $json_attributes = $this->as_json(false);
      foreach ($this->fields->readonly_fields()->external_ids() as $external_id) {
          if (isset($json_attributes['fields'][$external_id])) {
              unset($json_attributes['fields'][$external_id]);
          }
      }

      return $json_attributes;
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-22360
   */
  public static function get($item_id, $options = [])
  {
      $url = Podio::url_with_options("/item/{$item_id}", $options);

      return self::member(Podio::get($url));
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-by-app-item-id-66506688
   */
  public static function get_by_app_item_id($app_id, $app_item_id)
  {
      return self::member(Podio::get("/app/{$app_id}/item/{$app_item_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-by-external-id-19556702
   */
  public static function get_by_external_id($app_id, $external_id)
  {
      return self::member(Podio::get("/item/app/{$app_id}/external_id/{$external_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-basic-61768
   */
  public static function get_basic($item_id, $attributes = [])
  {
      return self::member(Podio::get("/item/{$item_id}/basic", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/items/filter-items-4496747
   */
  public static function filter($app_id, $attributes = [], $options = [])
  {
      $url = Podio::url_with_options("/item/app/{$app_id}/filter/", $options);

      return self::collection(Podio::post($url, $attributes ? $attributes : new StdClass()), 'PodioItemCollection');
  }

  /**
   * @see https://developers.podio.com/doc/items/filter-items-by-view-4540284
   */
  public static function filter_by_view($app_id, $view_id, $attributes = [], $options = [])
  {
      $url = Podio::url_with_options("/item/app/{$app_id}/filter/{$view_id}/", $options);

      return self::collection(Podio::post($url, $attributes ? $attributes : new StdClass()), 'PodioItemCollection');
  }

  /**
   * @see https://developers.podio.com/doc/items/delete-item-22364
   */
  public static function delete($item_id, $attributes = [], $options = [])
  {
      $url = Podio::url_with_options("/item/{$item_id}", $options);

      return Podio::delete($url, $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/items/bulk-delete-items-19406111
   */
  public static function bulk_delete($app_id, $attributes = [], $options = [])
  {
      $url = Podio::url_with_options("/item/app/{$app_id}/delete", $options);

      return Podio::post($url, $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/items/delete-item-reference-7302326
   */
  public static function delete_reference($item_id)
  {
      return Podio::delete("/item/{$item_id}/ref", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/items/add-new-item-22362
   */
  public static function create($app_id, $attributes = [], $options = [])
  {
      $url = Podio::url_with_options("/item/app/{$app_id}/", $options);

      return self::member(Podio::post($url, $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/items/clone-item-37722742
   */
  public static function duplicate($item_id, $options = [])
  {
      $url = Podio::url_with_options("/item/{$item_id}/clone", $options);
      $body = Podio::post($url)->json_body();

      return $body['item_id'];
  }

  /**
   * @see https://developers.podio.com/doc/items/update-item-22363
   */
  public static function update($item_id, $attributes = [], $options = [])
  {
      $url = Podio::url_with_options("/item/{$item_id}", $options);

      return Podio::put($url, $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/update-item-reference-7421495
   */
  public static function update_reference($item_id, $attributes = [])
  {
      return Podio::put("/item/{$item_id}/ref", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/update-item-values-22366
   */
  public static function update_values($item_id, $attributes = [], $options = [])
  {
      $url = Podio::url_with_options("/item/{$item_id}/value", $options);

      return Podio::put($url, $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/calculate-67633
   */
  public static function calculate($app_id, $attributes = [])
  {
      return Podio::post("/item/app/{$app_id}/calculate", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/export-items-4235696
   */
  public static function export($app_id, $exporter, $attributes = [])
  {
      $body = Podio::post("/item/app/{$app_id}/export/{$exporter}", $attributes ? $attributes : new StdClass())->json_body();

      return $body['batch_id'];
  }

  /**
   * @see https://developers.podio.com/doc/items/get-items-as-xlsx-63233
   */
  public static function xlsx($app_id, $attributes = [])
  {
      return Podio::get("/item/app/{$app_id}/xlsx/", $attributes)->body;
  }

  /**
   * @see https://developers.podio.com/doc/items/find-items-by-field-and-title-22485
   */
  public static function search_field($field_id, $attributes = [])
  {
      return Podio::get("/item/field/{$field_id}/find", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-count-34819997
   */
  public static function get_count($app_id)
  {
      $body = Podio::get("/item/app/{$app_id}/count")->json_body();

      return $body['count'];
  }

  /**
   * @see https://developers.podio.com/doc/items/get-app-values-22455
   */
  public static function get_app_values($app_id)
  {
      return Podio::get("/item/app/{$app_id}/values")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-field-values-22368
   */
  public static function get_field_value($item_id, $field_id)
  {
      return Podio::get("/item/{$item_id}/value/{$field_id}")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-preview-for-field-reference-7529318
   */
  public static function get_basic_by_field($item_id, $field_id)
  {
      return self::member(Podio::get("/item/{$item_id}/reference/{$field_id}/preview"));
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-references-22439
   */
  public static function get_references($item_id)
  {
      return Podio::get("/item/{$item_id}/reference/")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/get-meeting-url-14763260
   */
  public static function get_meeting_url($item_id)
  {
      $body = Podio::get("/item/{$item_id}/meeting/url")->json_body();

      return $body['url'];
  }

  /**
   * @see https://developers.podio.com/doc/items/get-item-preview-for-field-reference-7529318
   */
  public static function get_references_by_field($item_id, $field_id, $attributes = [])
  {
      return self::listing(Podio::get("/item/{$item_id}/reference/field/{$field_id}", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/items/get-top-values-for-field-68334
   */
  public static function get_top_values_by_field($field_id, $attributes = [])
  {
      return self::listing(Podio::get("/item/field/{$field_id}/top/", $attributes));
  }

  /**
   * @see https://developers.podio.com/doc/items/set-participation-7156154
   */
  public static function participation($item_id, $attributes = [])
  {
      return Podio::put("/item/{$item_id}/participation", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/items/revert-to-revision-194362682
   */
  public static function revert_to_revision($item_id, $revision, $attributes = [])
  {
      return Podio::post("/item/{$item_id}/revision/{$revision}/revert_to", $attributes);
  }
}
