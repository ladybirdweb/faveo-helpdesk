<?php

class PodioTextItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioTextItemField([
      '__api_values' => true,
      'field_id'     => 123,
      'values'       => [
        ['value' => 'FooBar'],
      ],
    ]);
        $this->empty_values = new PodioTextItemField(['field_id' => 1]);
    }

    public function test_can_construct_from_simple_value()
    {
        $object = new PodioTextItemField([
      'field_id' => 123,
      'values'   => 'FooBar',
    ]);
        $this->assertEquals('FooBar', $object->values);
    }

    public function test_can_provide_value()
    {
        $this->assertNull($this->empty_values->values);
        $this->assertEquals('FooBar', $this->object->values);
    }

    public function test_can_set_value()
    {
        $this->object->values = 'Baz';
        $this->assertEquals([['value' => 'Baz']], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        // Empty values
    $this->assertEquals('', $this->empty_values->humanized_value());

    // HTML content
    $html_values = new PodioTextItemField(['field_id' => 1]);
        $html_values->values = '<p>FooBar</p>';
        $this->assertEquals('FooBar', $html_values->humanized_value());

    // Populated values
    $this->assertEquals('FooBar', $this->object->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        $this->assertEquals('null', $this->empty_values->as_json());
        $this->assertEquals('"FooBar"', $this->object->as_json());
    }
}
