<?php

namespace Codedrop\Circle;

use Codedrop\Iterator\MapIterator;

class Build {

  /**
   * The build info directly from the API.
   *
   * @var array
   */
  protected $buildInfo;

  /**
   * Construct a new Circle Build.
   *
   * @param array $build
   *   The build info.
   */
  public function __construct(array $build) {
    $this->buildInfo = $build;
  }

  /**
   * Gets the last successful build time in seconds.

   * @return float
   *   The build time.
   */
  public function getPreviousSuccessfulBuildTime() {
    return $this->buildInfo['previous_successful_build']['build_time_millis'] / 1000;
  }

  /**
   * Gets the last successful build formatted as minutes:seconds.

   * @return string
   *   The build time formatted.
   */
  public function getPreviousSuccessfulBuildTimeFormatted() {
    return gmdate('i:s', $this->getPreviousSuccessfulBuildTime());
  }

  /**
   * Gets the build start time as a unix timestamp.
   *
   * @return int
   *   The unix timestamp for when the build begun.
   */
  public function getStartTime() {
    return strtotime($this->buildInfo['start_time']);
  }

  /**
   * Gets the very last step, last action's status.
   *
   * @return string
   *   The status string.
   */
  public function getLastActionStatus() {
    $last_step = $this->getLastStep();
    $last_action = $last_step->getLastAction();
    return $last_action->getStatus();
  }

  /**
   * Gets the build steps.
   *
   * @return \Codedrop\Circle\Step[]
   *   An iterator for the build steps.
   */
  public function getSteps() {
    return new MapIterator($this->buildInfo['steps'], function($step) {
      return new Step($step);
    });
  }

  /**
   * Gets the last step in the build. This can change if a build is running.
   *
   * @return \Codedrop\Circle\Step
   *   The current last step in this  build.
   */
  public function getLastStep() {
    $step = array_pop($this->buildInfo['steps']);
    $this->buildInfo['steps'][] = $step;
    return new Step($step);
  }

  /**
   * Check if our build is finished.
   *
   * @return bool
   *   TRUE is the build is finished otherwise FALSE.
   */
  public function isFinished() {
    return $this->buildInfo['lifecycle'] === 'finished';
  }

}
