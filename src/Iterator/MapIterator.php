<?php

namespace Circle\Iterator;

class MapIterator extends \ArrayIterator {

  /**
   * @var \Closure
   *   The callback function.
   */
  protected $callback;

  /**
   * Construct a new MapIterator.
   *
   * @param array $list
   *   The list of data to traverse.
   * @param \Closure $callback
   *   The callback to be called per item.
   *
   * @throws \InvalidArgumentException
   */
  public function __construct(array $list, $callback) {
    parent::__construct($list);
    if (!is_callable($callback)) {
      throw new \InvalidArgumentException('The function must be a PHP "callable"');
    }
    $this->callback = $callback;
  }

  /**
   * {@inheritdoc}
   */
  public function current() {
    // Call our custom function per item.
    return call_user_func($this->callback, parent::current());
  }

}
