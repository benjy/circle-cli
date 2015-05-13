<?php

namespace Circle\Tests\Command;

use Circle\Build;
use Circle\Tests\TestSetupTrait;

class ProgressCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  protected $circle;

  /**
   * The mock Circle config object.
   *
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  protected $circleConfig;

  /**
   * @var array
   */
  protected $config;

  public function setUp() {
    parent::setUp();
    $this->config['endpoints']['get_single_build'] = [
      'request' => [
        'circle-token' => '',
      ],
      'refresh-interval' => '0.1',
      'username' => 'username-in-config',
      'project' => 'project-name-in-config',
      'display' => ['committer_name'],
    ];
    $this->circleConfig = $this->getCircleConfigMock($this->config);
  }

  /**
   * Test the progress command executes without any issues.
   */
  public function testProgressCommandFinished() {
    // Get the mock circle config and service.
    $build_info = ['lifecycle' => 'finished', 'status' => 'success'];
    $this->circle = $this->getCircleServiceMock($this->circleConfig, $build_info);
    $this->circle
      ->expects($this->once())
      ->method('queryCircle')
      ->willReturn($build_info);

    $command = $this->getCommand('Circle\Command\ProgressCommand', $this->circle);
    $commandTester = $this->runCommand($command, ['--build-num' => '3']);
    $this->assertContains('Build has finished', $commandTester->getDisplay());
  }

  /**
   * Test the progress command bar and table output.
   */
  public function testProgressCommand() {
    // Get the mock circle config and service.
    $build_info = [
      'status' => 'success',
      'lifecycle' => 'running',
      'committer_name' => 'Committer Name',
      // Set the last build time to ten minutes in milliseconds.
      'previous_successful_build' => ['build_time_millis' => 10 * 60 * 1000],
      'start_time' => date(DATE_ISO8601),
      'steps' => [
        ['name' => 'step_one', 'actions' => [['status' => 'success', 'run_time_millis' => 3000]]],
        ['name' => 'step_two', 'actions' => [['status' => 'running', 'run_time_millis' => NULL]]],
      ]
    ];
    $build_info2 = $build_info;
    $build_info2['lifecycle'] = 'finished';

    $this->circle = $this->getCircleServiceMock($this->circleConfig, FALSE);
    $this->circle
      ->expects($this->any())
      ->method('queryCircle')
      ->willReturnOnConsecutiveCalls($build_info, $build_info2, $build_info, $build_info2);

    // Test the progress formatter.
    $command = $this->getCommand('Circle\Command\ProgressCommand', $this->circle);
    $commandTester = $this->runCommand($command, ['--build-num' => '3', '--refresh-interval' => '0.1']);

    $display_output = $commandTester->getDisplay();
    $this->assertContains('Build has finished', $display_output, 'Build marked as finished');
    $this->assertContains('Committer Name', $display_output, 'Committer name appeared in build output.');
    $this->assertContains('0/10', $display_output, 'Build started at 0 from 10 minutes.');
    $this->assertContains('10/10', $display_output, 'Build finished with ...');
    $this->assertContains('100%', $display_output);

    // Test the table formatter.
    $command = $this->getCommand('Circle\Command\ProgressCommand', $this->circle);
    $commandTester = $this->runCommand($command, ['--build-num' => '3', '--format' => 'table']);

    $display_output = $commandTester->getDisplay();
    $this->assertContains('00:03', $display_output, 'Run time correct.');
    $this->assertContains('step_one', $display_output);
    $this->assertContains('step_two', $display_output);
  }

}
