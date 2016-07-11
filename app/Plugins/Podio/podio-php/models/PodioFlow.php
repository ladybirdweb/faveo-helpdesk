<?php
/**
 * @see https://developers.podio.com/doc/flows
 */
class PodioFlow extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('flow_id', 'integer', ['id' => true]);
        $this->property('name', 'string');
        $this->property('type', 'string');
        $this->property('config', 'hash');
        $this->property('effects', 'hash');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/flows/get-flow-by-id-26312313
   */
  public static function get($flow_id)
  {
      return Podio::get("/flow/{$flow_id}")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/flows/add-new-flow-26309928
   */
  public static function create($ref_type, $ref_id, $attributes = [])
  {
      return Podio::post("/flow/{$ref_type}/{$ref_id}/", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/flows/update-flow-26310901
   */
  public static function update($flow_id, $attributes = [])
  {
      return Podio::put("/flow/{$flow_id}", $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/flows/delete-flow-32929229
   */
  public static function delete($flow_id)
  {
      return Podio::delete("/flow/{$flow_id}");
  }

  /**
   * @see https://developers.podio.com/doc/flows/get-flows-26312304
   */
  public static function get_flows($ref_type, $ref_id)
  {
      return Podio::get("/flow/{$ref_type}/{$ref_id}/")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/flows/get-effect-attributes-239234961
   */
  public static function get_effect_attributes($ref_type, $ref_id)
  {
      return Podio::post("/flow/{$ref_type}/{$ref_id}/effect/attributes")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/flows/get-flow-context-26313659
   */
  public static function get_flow_context($flow_id)
  {
      return Podio::get("/flow/{$flow_id}/context/")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/flows/get-possible-attributes-33060379
   */
  public static function get_possible_attributes($ref_type, $ref_id)
  {
      return Podio::post("/flow/{$ref_type}/{$ref_id}/attributes/")->json_body();
  }
}
