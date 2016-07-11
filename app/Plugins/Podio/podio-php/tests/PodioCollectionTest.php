<?php

class PodioCollectionTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->collection = new PodioCollection();

        $external_ids = ['a', 'b', 'c'];
        for ($i = 1; $i < 4; $i++) {
            $item = new PodioItem();
            $item->property('id', 'integer');
            $item->property('external_id', 'string');
            $item->init();

            $item->id = $i;
            $item->external_id = $external_ids[$i - 1];

            $this->collection[] = $item;
        }
    }

    public function test_can_get_by_offset()
    {
        $item = $this->collection[1];
        $this->assertEquals(2, $item->id);
    }

    public function test_can_iterate()
    {
        $checklist = [1, 2, 3];
        foreach ($this->collection as $offset => $item) {
            $this->assertEquals($checklist[$offset], $item->id);
        }
    }

    public function test_can_provide_length()
    {
        $this->assertEquals(3, count($this->collection));
    }

    public function test_can_check_existence()
    {
        $this->assertTrue(isset($this->collection[0]));
        $this->assertFalse(isset($this->collection[3]));
    }

  /**
   * @expectedException PodioDataIntegrityError
   */
  public function test_cannot_add_string()
  {
      $this->collection[] = 'Sample String';
  }

    public function test_can_add_object()
    {
        $length = count($this->collection);
        $this->collection[] = new PodioObject();

        $this->assertEquals($length + 1, count($this->collection));
    }

    public function test_can_remove_by_offset()
    {
        unset($this->collection[0]);
        $this->assertEquals(2, count($this->collection));
        $this->assertFalse(isset($this->collection[0]));
    }

    public function test_can_remove_by_id()
    {
        $this->collection->remove(1);
        $this->assertEquals(2, count($this->collection));
        $this->assertNull($this->collection->get(1));
    }

    public function test_can_remove_by_external_id()
    {
        $this->collection->remove('a');
        $this->assertEquals(2, count($this->collection));
        $this->assertNull($this->collection->get(1));
    }

    public function test_can_get_by_id()
    {
        $this->assertEquals('b', $this->collection->get(2)->external_id);
    }

    public function test_can_get_by_external_id()
    {
        $this->assertEquals(2, $this->collection->get('b')->id);
    }

    public function test_can_add_relationship()
    {
        $instance = new PodioObject();

        $this->collection->add_relationship($instance, 'fields');

        $relationship = $this->collection->relationship();
        $this->assertEquals($instance, $relationship['instance']);
        $this->assertEquals('fields', $relationship['property']);

        foreach ($this->collection as $object) {
            $relationship = $object->relationship();
            $this->assertEquals($instance, $relationship['instance']);
            $this->assertEquals('fields', $relationship['property']);
        }
    }
}
