<?php

class PodioDurationItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioDurationItemField([
      '__api_values' => true,
      'field_id'     => 123,
      'values'       => [
        ['value' => 3723],
      ],
    ]);

        $this->empty_values = new PodioDurationItemField([
      'field_id' => 456,
    ]);
    }

    public function test_can_construct_from_simple_value()
    {
        $object = new PodioDurationItemField([
      'field_id' => 123,
      'values'   => 3600,
    ]);
        $this->assertEquals(3600, $object->values);
    }

    public function test_can_provide_value()
    {
        $this->assertNull($this->empty_values->values);
        $this->assertEquals(3723, $this->object->values);
    }

    public function test_can_provide_hours()
    {
        $this->assertEquals(0, $this->empty_values->hours);
        $this->assertEquals(1, $this->object->hours);
    }

    public function test_can_provide_minutes()
    {
        $this->assertEquals(0, $this->empty_values->minutes);
        $this->assertEquals(2, $this->object->minutes);
    }

    public function test_can_provide_seconds()
    {
        $this->assertEquals(0, $this->empty_values->seconds);
        $this->assertEquals(3, $this->object->seconds);
    }

    public function test_can_set_value()
    {
        $this->object->values = 123;
        $this->assertEquals([['value' => 123]], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        $this->assertEquals('00:00:00', $this->empty_values->humanized_value());
        $this->assertEquals('01:02:03', $this->object->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        $this->assertEquals('null', $this->empty_values->as_json());
        $this->assertEquals(3723, $this->object->as_json());
    }
}
