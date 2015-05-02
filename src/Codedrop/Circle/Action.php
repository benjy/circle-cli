<?php

namespace Codedrop\Circle;

class Action {

  /**
   * The action info straight from the API.
   *
   * @var array
   */
  protected $actionInfo;

  /**
   * Constructs a new action object.
   *
   * @param array $action
   *   The action info.
   */
  public function __construct(array $action) {
    $this->actionInfo = $action;
  }

  /**
   * Gets the action status.
   *
   * @return string
   *   The current status for this action.
   */
  public function getStatus() {
    return $this->actionInfo['status'];
  }

  /**
   * Gets the last run time for this action.
   *
   * @return int|null
   *   The run time for this action.
   */
  public function getRunTime() {
    return $this->actionInfo['run_time_millis'];
  }

}
