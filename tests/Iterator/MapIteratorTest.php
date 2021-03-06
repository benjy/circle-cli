<?php

namespace Circle\Tests\Iterator;

use Circle\Iterator\MapIterator;

class MapIteratorTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test the iterator applies our callback as expected.
   */
  public function testMapIterator() {
    $values = ['value1', 'value2', 'value3'];
    $iterator = new MapIterator($values, function($val) {
      return $val . '_done';
    });
    foreach ($iterator as $i => $item) {
      $this->assertEquals($values[$i] . '_done', $item);
    }
    $this->assertEquals($iterator[0], 'value1_done');
  }

  /**
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage The function must be a PHP "callable"
   */
  public function testMapIteratorInvalidCallback() {
    new MapIterator([], '');
  }

}
