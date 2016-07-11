<?php

class PodioMoneyItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioMoneyItemField([
      '__api_values' => true,
      'field_id'     => 123,
      'values'       => [
        ['value' => '123.5568', 'currency' => 'USD'],
      ],
    ]);

        $this->empty_values = new PodioMoneyItemField([
      'field_id' => 456,
    ]);

        $this->zero_value = new PodioMoneyItemField([
      '__api_values' => true,
      'field_id'     => 789,
      'values'       => [
        ['value' => '0', 'currency' => 'USD'],
      ],
    ]);
    }

    public function test_can_construct_from_simple_value()
    {
        $object = new PodioMoneyItemField([
      'field_id' => 123,
      'values'   => ['value' => '456.67', 'currency' => 'BTC'],
    ]);
        $this->assertEquals([['value' => '456.67', 'currency' => 'BTC']], $object->__attribute('values'));
    }

    public function test_can_provide_value()
    {
        $this->assertNull($this->empty_values->values);
        $this->assertEquals(['value' => '123.5568', 'currency' => 'USD'], $this->object->values);
        $this->assertEquals(['value' => '0', 'currency' => 'USD'], $this->zero_value->values);
    }

    public function test_can_provide_amount()
    {
        $this->assertNull($this->empty_values->amount);
        $this->assertEquals('123.5568', $this->object->amount);
        $this->assertEquals('0', $this->zero_value->amount);
    }

    public function test_can_provide_currency()
    {
        // $this->assertNull($this->empty_values->currency);
    $this->assertEquals('USD', $this->object->currency);
        $this->assertEquals('USD', $this->zero_value->currency);
    }

    public function test_can_set_value()
    {
        $this->object->values = ['value' => '456.67', 'currency' => 'BTC'];
        $this->assertEquals([['value' => '456.67', 'currency' => 'BTC']], $this->object->__attribute('values'));

        $this->object->values = ['value' => '0', 'currency' => 'BTC'];
        $this->assertEquals([['value' => '0', 'currency' => 'BTC']], $this->object->__attribute('values'));
    }

    public function test_can_set_amount()
    {
        $this->object->amount = '456.67';
        $this->assertEquals([['value' => '456.67', 'currency' => 'USD']], $this->object->__attribute('values'));

        $this->object->amount = '0';
        $this->assertEquals([['value' => '0', 'currency' => 'USD']], $this->object->__attribute('values'));
    }

    public function test_can_set_currency()
    {
        $this->object->currency = 'BTC';
        $this->assertEquals([['value' => '123.5568', 'currency' => 'BTC']], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        $this->assertEquals('', $this->empty_values->humanized_value());
        $this->assertEquals('$123.56', $this->object->humanized_value());
        $this->assertEquals('$0.00', $this->zero_value->humanized_value());

        $this->object->currency = 'GBP';
        $this->assertEquals('£123.56', $this->object->humanized_value());

        $this->object->currency = 'EUR';
        $this->assertEquals('€123.56', $this->object->humanized_value());

        $this->object->currency = 'DKK';
        $this->assertEquals('DKK 123.56', $this->object->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        $this->assertEquals('null', $this->empty_values->as_json());
        $this->assertEquals('{"value":"123.5568","currency":"USD"}', $this->object->as_json());
        $this->assertEquals('{"value":"0","currency":"USD"}', $this->zero_value->as_json());
    }
}
