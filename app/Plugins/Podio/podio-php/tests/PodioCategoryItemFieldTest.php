<?php

class PodioCategoryItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioCategoryItemField([
      '__api_values' => true,
      'field_id'     => 123,
      'values'       => [
        ['value' => ['id' => 1, 'text' => 'Snap']],
        ['value' => ['id' => 2, 'text' => 'Crackle']],
        ['value' => ['id' => 3, 'text' => 'Pop']],
      ],
    ]);
    }

    public function test_can_construct_from_simple_value()
    {
        $object = new PodioCategoryItemField([
      'field_id' => 123,
      'values'   => 4,
    ]);
        $this->assertEquals([['value' => ['id' => 4]]], $object->__attribute('values'));
    }

    public function test_can_provide_value()
    {
        // Empty values
    $empty_values = new PodioCategoryItemField(['field_id' => 1]);
        $this->assertNull($empty_values->values);

    // Populated values
    $this->assertEquals([['id' => 1, 'text' => 'Snap'], ['id' => 2, 'text' => 'Crackle'], ['id' => 3, 'text' => 'Pop']], $this->object->values);
    }

    public function test_can_set_values_from_id()
    {
        $this->object->values = 4;
        $this->assertEquals([['value' => ['id' => 4]]], $this->object->__attribute('values'));
    }

    public function test_can_set_values_from_array()
    {
        $this->object->values = [4];
        $this->assertEquals([['value' => ['id' => 4]]], $this->object->__attribute('values'));
    }

    public function test_can_set_values_from_hash()
    {
        $this->object->values = [['id' => 4, 'text' => 'Captain Crunch']];
        $this->assertEquals([['value' => ['id' => 4, 'text' => 'Captain Crunch']]], $this->object->__attribute('values'));
    }

    public function test_can_add_value_from_id()
    {
        $this->object->add_value(4);
        $this->assertEquals([
      ['value' => ['id' => 1, 'text' => 'Snap']],
      ['value' => ['id' => 2, 'text' => 'Crackle']],
      ['value' => ['id' => 3, 'text' => 'Pop']],
      ['value' => ['id' => 4]],
    ], $this->object->__attribute('values'));
    }

    public function test_can_add_value_from_hash()
    {
        $this->object->add_value(['id' => 4, 'text' => 'Captain Crunch']);
        $this->assertEquals([
      ['value' => ['id' => 1, 'text' => 'Snap']],
      ['value' => ['id' => 2, 'text' => 'Crackle']],
      ['value' => ['id' => 3, 'text' => 'Pop']],
      ['value' => ['id' => 4, 'text' => 'Captain Crunch']],
    ], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        // Empty values
    $empty_values = new PodioCategoryItemField(['field_id' => 1]);
        $this->assertEquals('', $empty_values->humanized_value());

    // Populated values
    $this->assertEquals('Snap;Crackle;Pop', $this->object->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        // Empty values
    $empty_values = new PodioCategoryItemField(['field_id' => 1]);
        $this->assertEquals('[]', $empty_values->as_json());

    // Populated values
    $this->assertEquals('[1,2,3]', $this->object->as_json());
    }
}
