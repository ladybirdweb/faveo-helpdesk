<?php

class PodioPhoneItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioPhoneItemField([
      '__api_values' => true,
      'values'       => [
        ['type' => 'work', 'value' => '0123-1233333'],
        ['type' => 'other', 'value' => '0232-123123'],
      ],
    ]);
    }

    public function test_can_provide_value()
    {
        // Empty values
    $empty_values = new PodioPhoneItemField();
        $this->assertNull($empty_values->values);

    // Populated values
    $this->assertEquals([
        ['type' => 'work', 'value' => '0123-1233333'],
        ['type' => 'other', 'value' => '0232-123123'],
      ], $this->object->values);
    }

    public function test_can_set_value_from_hash()
    {
        $this->object->values = [
      ['type' => 'work', 'value' => '0123-999'],
      ['type' => 'other', 'value' => '0232-999'],
    ];
        $this->assertEquals([
      ['type' => 'work', 'value' => '0123-999'],
      ['type' => 'other', 'value' => '0232-999'],
    ], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        // Empty values
    $empty_values = new PodioPhoneItemField();
        $this->assertEquals('', $empty_values->humanized_value());

    // Populated values
    $this->assertEquals('work: 0123-1233333;other: 0232-123123', $this->object->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        // Empty values
    $empty_values = new PodioPhoneItemField();
        $this->assertEquals('[]', $empty_values->as_json());

    // Populated values
    $this->assertEquals('[{"type":"work","value":"0123-1233333"},{"type":"other","value":"0232-123123"}]', $this->object->as_json());
    }
}
