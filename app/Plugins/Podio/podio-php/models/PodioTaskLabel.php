<?php
/**
 * @see https://developers.podio.com/doc/tasks
 */
class PodioTaskLabel extends PodioObject
{
    const DEFAULT_COLOR = 'E9E9E9';

    public function __construct($attributes = [])
    {
        $this->property('label_id', 'integer', ['id' => true]);
        $this->property('text', 'string');
        $this->property('color', 'string');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/tasks/create-label-151265
   */
  public static function create($attributes = [])
  {
      if (!isset($attributes['color'])) {
          $attributes['color'] = DEFAULT_COLOR;
      }
      $body = Podio::post('/task/label/', $attributes)->json_body();
      $body['label_id'];
  }

  /**
   * @see https://developers.podio.com/doc/tasks/get-labels-151534
   */
  public static function get_all()
  {
      return self::listing(Podio::get('/task/label'));
  }

  /**
   * @see https://developers.podio.com/doc/tasks/delete-label-151302
   */
  public static function delete($label_id)
  {
      return Podio::delete("/task/label/{$label_id}");
  }

  /**
   * @see https://developers.podio.com/doc/tasks/update-task-labels-151769
   */
  public static function update($label_id, $attributes = [])
  {
      return Podio::put("/task/label/{$label_id}", $attributes);
  }
}
