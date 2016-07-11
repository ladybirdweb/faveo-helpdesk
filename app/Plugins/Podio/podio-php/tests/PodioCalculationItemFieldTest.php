<?php

class PodioCalculationItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioCalculationItemField([
      '__api_values' => true,
      'field_id'     => 123,
      'values'       => [
        ['value' => '1234.5600'],
      ],
    ]);
        $this->empty_values = new PodioCalculationItemField(['field_id' => 1]);
        $this->zero_value = new PodioCalculationItemField(['__api_values' => true, 'field_id' => 2, 'values' => [['value' => '0']]]);
    }

    public function test_can_provide_value()
    {
        $this->assertNull($this->empty_values->values);
        $this->assertEquals('1234.5600', $this->object->values);
        $this->assertEquals('0', $this->zero_value->values);
    }

    public function test_cannot_modify_value()
    {
        $this->object->values = '12.34';
        $this->assertEquals([['value' => '1234.5600']], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        $this->assertEquals('', $this->empty_values->humanized_value());
        $this->assertEquals('1234.56', $this->object->humanized_value());
        $this->assertEquals('0', $this->zero_value->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        $this->assertEquals('null', $this->empty_values->as_json());
        $this->assertEquals('"1234.5600"', $this->object->as_json());
        $this->assertEquals('"0"', $this->zero_value->as_json());
    }
}
