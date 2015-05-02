<?php

namespace Codedrop\Circle;

class Step {

  /**
   * The step information direct from the API.
   *
   * @var array
   */
  protected $stepInfo;

  /**
   * Constructs a new Step.
   *
   * @param array $step
   *   The step info.
   */
  public function __construct(array $step) {
    $this->stepInfo = $step;
  }

  /**
   * Gets the step name.
   *
   * @return string
   *   The name of the step.
   */
  public function getName() {
    return $this->stepInfo['name'];
  }

  /**
   * Gets the last action in this step.
   *
   * @return \Codedrop\Circle\Action
   *   The last action.
   */
  public function getLastAction() {
    $action = array_pop($this->stepInfo['actions']);
    $this->stepInfo['actions'][] = $action;
    return new Action($action);
  }

  /**
   * Checks the running status.
   *
   * @return bool
   *   TRUE if this step is currently running otherwise FALSE.
   */
  public function isRunning() {
    return $this->getLastAction()->getStatus() === 'running';
  }

}
