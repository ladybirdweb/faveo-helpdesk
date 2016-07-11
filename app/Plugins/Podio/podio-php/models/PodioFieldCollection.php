<?php

/**
 * A collection for managing a list of PodioAppFields or PodioItemFields.
 * Don't instantiate this class manually. Use PodioAppFieldCollection or
 * PodioItemFieldCollection.
 */
class PodioFieldCollection extends PodioCollection
{
    private $__belongs_to;

  /**
   * Constructor. Pass in an array of fields.
   */
  public function __construct($fields)
  {
      parent::__construct($fields);
  }

  /**
   * Array access. Set fiels using external id or offset.
   */
  public function offsetSet($offset, $field)
  {

    // Allow you to set external id in the array offset.
    // E.g. $collection['external_id'] = $field;
    if (is_string($offset)) {
        $field->external_id = $offset;
        $offset = null;
    }

      if (!$field->id && !$field->external_id) {
          throw new PodioDataIntegrityError('Field must have id or external_id set.');
      }

    // Remove any existing field with this id
    $this->remove($field->id ? $field->id : $field->external_id);

    // Add to internal storage
    parent::offsetSet($offset, $field);
  }

  /**
   * Array access. Check for existence using external_id or offset.
   */
  public function offsetExists($offset)
  {
      if (is_string($offset)) {
          return $this->get($offset) ? true : false;
      }

      return parent::offsetExists($offset);
  }

  /**
   * Array access. Unset field using external)id or offset.
   */
  public function offsetUnset($offset)
  {
      if (is_string($offset)) {
          $this->remove($offset);
      } else {
          parent::offsetUnset($offset);
      }
  }

  /**
   * Array access. Get field using external_id or offset.
   */
  public function offsetGet($offset)
  {
      if (is_string($offset)) {
          return $this->get($offset);
      }

      return parent::offsetGet($offset);
  }

  /**
   * Returns all external_ids in use on this item.
   */
  public function external_ids()
  {
      return array_map(function ($field) {
          return $field->external_id;
      }, $this->_get_items());
  }

  /**
   * Returns all readonly fields.
   */
  public function readonly_fields()
  {
      $fields = new self([]);
      foreach ($this->_get_items() as $field) {
          if ($field->type === 'calculation') {
              $fields[] = $field;
          }
      }

      return $fields;
  }
}
