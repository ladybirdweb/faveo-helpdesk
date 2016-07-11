<?php

class PodioLocationItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioLocationItemField([
      '__api_values' => true,
      'field_id'     => 123,
      'values'       => [
        ['value' => '650 Townsend St., San Francisco, CA 94103', 'lat' => 37.7710325, 'lng' => -122.4033069],
      ],
    ]);

        $this->empty_values = new PodioLocationItemField(['field_id' => 1]);
    }

    public function test_can_construct_from_simple_value()
    {
        $object = new PodioLocationItemField([
      'field_id' => 123,
      'values'   => ['value' => '650 Townsend St., San Francisco, CA 94103', 'lat' => 37.7710325, 'lng' => -122.4033069],
    ]);
        $this->assertEquals([['value' => '650 Townsend St., San Francisco, CA 94103', 'lat' => 37.7710325, 'lng' => -122.4033069]], $object->__attribute('values'));
    }

    public function test_can_provide_value()
    {
        // Empty values
    $this->assertNull($this->empty_values->values);

    // Populated values
    $this->assertEquals(['value' => '650 Townsend St., San Francisco, CA 94103', 'lat' => 37.7710325, 'lng' => -122.4033069], $this->object->values);
    }

    public function test_can_provide_text()
    {
        $this->assertNull($this->empty_values->text);
        $this->assertEquals('650 Townsend St., San Francisco, CA 94103', $this->object->text);
    }

    public function test_can_set_value()
    {
        $this->object->values = ['value' => 'Vesterbrogade 34, 1620 Copenhagen V, Denmark', 'lat' => 55.6725581, 'lng' => 12.5564512];
        $this->assertEquals([['value' => 'Vesterbrogade 34, 1620 Copenhagen V, Denmark', 'lat' => 55.6725581, 'lng' => 12.5564512]], $this->object->__attribute('values'));
    }

    public function test_can_set_text()
    {
        $this->object->text = 'Vesterbrogade 34, 1620 Copenhagen V, Denmark';
        $this->assertEquals([['value' => 'Vesterbrogade 34, 1620 Copenhagen V, Denmark', 'lat' => 37.7710325, 'lng' => -122.4033069]], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        // Empty values
    $this->assertEquals('', $this->empty_values->humanized_value());

    // Populated values
    $this->assertEquals('650 Townsend St., San Francisco, CA 94103', $this->object->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        // Empty values
    $this->assertEquals('null', $this->empty_values->as_json());

    // Populated values
    $this->assertEquals('{"value":"650 Townsend St., San Francisco, CA 94103","lat":37.7710325,"lng":-122.4033069}', $this->object->as_json());
    }
}
