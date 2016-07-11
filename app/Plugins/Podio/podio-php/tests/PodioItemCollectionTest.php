<?php

class PodioItemCollectionTest extends PHPUnit_Framework_TestCase
{
    /**
   * @expectedException PodioDataIntegrityError
   */
  public function test_cannot_add_object()
  {
      $collection = new PodioItemCollection();
      $collection[] = new PodioObject();
  }

    public function test_can_add_item()
    {
        $collection = new PodioItemCollection();
        $length = count($collection);
        $collection[] = new PodioItem(['item_id' => 1, 'external_id' => 'a']);

        $this->assertEquals($length + 1, count($collection));
    }
}
