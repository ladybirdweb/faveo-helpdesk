<?php

/**
 * Provides a very simple iterator and array access interface to a collection
 * of PodioObject models.
 */
class PodioCollection implements IteratorAggregate, ArrayAccess, Countable
{
    private $__items = [];
    private $__belongs_to;

  /**
   * Constructor. Pass in an array of PodioObject objects.
   */
  public function __construct($items = [])
  {
      foreach ($items as $item) {
          $this->offsetSet(null, $item);
      }
  }

  /**
   * Convert collection to string.
   */
  public function __toString()
  {
      $items = [];
      foreach ($this->__items as $item) {
          $items[] = $item->as_json(false);
      }

      return print_r($items, true);
  }

  /**
   * Implements Countable.
   */
  public function count()
  {
      return count($this->__items);
  }

  /**
   * Implements IteratorAggregate.
   */
  public function getIterator()
  {
      return new ArrayIterator($this->__items);
  }

  /**
   * Array access. Set item by offset, automatically adding relationship.
   */
  public function offsetSet($offset, $value)
  {
      if (!is_a($value, 'PodioObject')) {
          throw new PodioDataIntegrityError('Objects in PodioCollection must be of class PodioObject');
      }

    // If the collection has a relationship with a parent, add it to the item as well.
    $relationship = $this->relationship();
      if ($relationship) {
          $value->add_relationship($relationship['instance'], $relationship['property']);
      }

      if (is_null($offset)) {
          $this->__items[] = $value;
      } else {
          $this->__items[$offset] = $value;
      }
  }

  /**
   * Array access. Check for existence.
   */
  public function offsetExists($offset)
  {
      return isset($this->__items[$offset]);
  }

  /**
   * Array access. Unset.
   */
  public function offsetUnset($offset)
  {
      unset($this->__items[$offset]);
  }

  /**
   * Array access. Get.
   */
  public function offsetGet($offset)
  {
      return isset($this->__items[$offset]) ? $this->__items[$offset] : null;
  }

  /**
   * Return the raw array of objects. Internal use only.
   */
  public function _get_items()
  {
      return $this->__items;
  }

  /**
   * Set the raw array of objects. Internal use only.
   */
  public function _set_items($items)
  {
      $this->__items = $items;
  }

  /**
   * Return any relationship to a parent object.
   */
  public function relationship()
  {
      return $this->__belongs_to;
  }

  /**
   * Add a new relationship to a parent object. Will also add relationship
   * to all individual objects in the collection.
   */
  public function add_relationship($instance, $property = 'fields')
  {
      $this->__belongs_to = ['property' => $property, 'instance' => $instance];

    // Add relationship to all individual fields as well.
    foreach ($this as $item) {
        if ($item->has_property($property)) {
            $item->add_relationship($instance, $property);
        }
    }
  }

  /**
   * Get object in the collection by id or external_id.
   */
  public function get($id_or_external_id)
  {
      $key = is_int($id_or_external_id) ? 'id' : 'external_id';
      foreach ($this as $item) {
          if ($item->{$key} === $id_or_external_id) {
              return $item;
          }
      }
  }

  /**
   * Remove object from collection by id or external_id.
   */
  public function remove($id_or_external_id)
  {
      if (count($this) === 0) {
          return true;
      }
      $this->_set_items(array_filter($this->_get_items(), function ($item) use ($id_or_external_id) {
          return !($item->id == $id_or_external_id || $item->external_id == $id_or_external_id);
      }));
  }
}
