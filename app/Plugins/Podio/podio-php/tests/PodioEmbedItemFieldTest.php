<?php

class PodioEmbedItemFieldTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->object = new PodioEmbedItemField([
      '__api_values' => true,
      'values'       => [
        ['embed' => ['embed_id' => 1, 'original_url' => 'http://example.com/'], 'file' => ['file_id' => 10]],
        ['embed' => ['embed_id' => 2]],
        ['embed' => ['embed_id' => 3, 'original_url' => 'http://example.org/'], 'file' => ['file_id' => 11]],
      ],
    ]);
    }

    public function test_can_construct_from_simple_value()
    {
        $object = new PodioEmbedItemField([
      'field_id' => 123,
      'values'   => ['embed' => ['embed_id' => 4], 'file' => ['file_id' => 12]],
    ]);
        $this->assertEquals([
      ['embed' => ['embed_id' => 4], 'file' => ['file_id' => 12]],
    ], $object->__attribute('values'));
    }

    public function test_can_provide_value()
    {
        // Empty values
    $empty_values = new PodioEmbedItemField(['field_id' => 1]);
        $this->assertNull($empty_values->values);

    // Populated values
    $this->assertInstanceOf('PodioCollection', $this->object->values);
        $this->assertEquals(3, count($this->object->values));
        foreach ($this->object->values as $value) {
            $this->assertInstanceOf('PodioEmbed', $value);
            if ($value->files) {
                foreach ($value->files as $file) {
                    $this->assertInstanceOf('PodioFile', $file);
                }
            }
        }
    }

    public function test_can_set_value_from_object()
    {
        $this->object->values = new PodioEmbed(['embed_id' => 4, 'original_url' => 'http://example.com/', 'files' => [['file_id' => 12]]]);
        $this->assertEquals([
      ['embed' => ['embed_id' => 4, 'original_url' => 'http://example.com/'], 'file' => ['file_id' => 12]],
    ], $this->object->__attribute('values'));
    }

    public function test_can_set_value_from_collection()
    {
        $this->object->values = new PodioCollection([new PodioEmbed(['embed_id' => 4, 'original_url' => 'http://example.net/'])]);

        $this->assertEquals([
      ['embed' => ['embed_id' => 4, 'original_url' => 'http://example.net/'], 'file' => null],
    ], $this->object->__attribute('values'));
    }

    public function test_can_set_value_from_hash()
    {
        $this->object->values = ['embed' => ['embed_id' => 4], 'file' => ['file_id' => 12]];
        $this->assertEquals([
      ['embed' => ['embed_id' => 4], 'file' => ['file_id' => 12]],
    ], $this->object->__attribute('values'));
    }

    public function test_can_set_value_from_array_of_objects()
    {
        $this->object->values = [
      new PodioEmbed(['embed_id' => 4, 'files' => [['file_id' => 12]]]),
      new PodioEmbed(['embed_id' => 5, 'files' => [['file_id' => 13]]]),
    ];
        $this->assertEquals([
      ['embed' => ['embed_id' => 4], 'file' => ['file_id' => 12]],
      ['embed' => ['embed_id' => 5], 'file' => ['file_id' => 13]],
    ], $this->object->__attribute('values'));
    }

    public function test_can_set_value_from_array_of_hashes()
    {
        $this->object->values = [
      ['embed' => ['embed_id' => 4], 'file' => ['file_id' => 12]],
      ['embed' => ['embed_id' => 5], 'file' => ['file_id' => 13]],
    ];
        $this->assertEquals([
      ['embed' => ['embed_id' => 4], 'file' => ['file_id' => 12]],
      ['embed' => ['embed_id' => 5], 'file' => ['file_id' => 13]],
    ], $this->object->__attribute('values'));
    }

    public function test_can_humanize_value()
    {
        // Empty values
    $empty_values = new PodioEmbedItemField(['field_id' => 1]);
        $this->assertEquals('', $empty_values->humanized_value());

    // Populated values
    $this->assertEquals('http://example.com/;;http://example.org/', $this->object->humanized_value());
    }

    public function test_can_convert_to_api_friendly_json()
    {
        // Empty values
    $empty_values = new PodioEmbedItemField(['field_id' => 1]);
        $this->assertEquals('[]', $empty_values->as_json());

    // Populated values
    $this->assertEquals('[{"embed":1,"file":10},{"embed":2,"file":null},{"embed":3,"file":11}]', $this->object->as_json());
    }
}
