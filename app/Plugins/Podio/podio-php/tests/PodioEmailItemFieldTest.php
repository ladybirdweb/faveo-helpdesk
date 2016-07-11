<?php

class PodioEmailItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioEmailItemField([
      '__api_values' => true,
      'values'       => [
        ['type' => 'work', 'value' => 'mail@example.com'],
        ['type' => 'other', 'value' => 'info@example.com'],
      ],
    ]);
    }

    public function test_can_provide_value()
    {
        // Empty values
    $empty_values = new PodioEmailItemField();
        $this->assertNull($empty_values->values);

    // Populated values
    $this->assertEquals([
        ['type' => 'work', 'value' => 'mail@example.com'],
        ['type' => 'other', 'value' => 'info@example.com'],
      ], $this->object->values);
    }

    public function test_can_set_value_from_hash()
    {
        $this->object->values = [
      ['type' => 'work', 'value' => 'other@example.com'],
      ['type' => 'other', 'value' => '42@example.com'],
    ];
        $this->assertEquals([
      ['type' => 'work', 'value' => 'other@example.com'],
      ['type' => 'other', 'value' => '42@example.com'],
    ], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        // Empty values
    $empty_values = new PodioEmailItemField();
        $this->assertEquals('', $empty_values->humanized_value());

    // Populated values
    $this->assertEquals('work: mail@example.com;other: info@example.com', $this->object->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        // Empty values
    $empty_values = new PodioEmailItemField();
        $this->assertEquals('[]', $empty_values->as_json());

    // Populated values
    $this->assertEquals('[{"type":"work","value":"mail@example.com"},{"type":"other","value":"info@example.com"}]', $this->object->as_json());
    }
}
