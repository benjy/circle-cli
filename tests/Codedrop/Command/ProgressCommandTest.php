<?php

namespace Codedrop\Tests\Command;

require_once __DIR__  . "/../TestSetupTrait.php";

use Codedrop\Circle\Build;
use Codedrop\Tests\TestSetupTrait;

class ProgressCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  protected $circle;

  /**
   * @var array
   */
  protected $config;

  public function setUp() {
    parent::setUp();
    $this->config['endpoints']['get_single_build'] = [
      'request' => [
        'circle-token' => '',
        'username' => 'username-in-config',
        'project' => 'project-name-in-config',
      ],
      'display' => ['committer_name'],
    ];
    $circle_config = $this->getCircleConfigMock($this->config);
    $this->circle = $this->getCircleServiceMock($circle_config);
  }

  /**
   * Test the progress command executes without any issues.
   */
  public function testProgressCommandFinished() {
    // Get the mock circle config and service.
    $build_info = ['lifecycle' => 'finished', 'status' => 'success'];
    $this->circle->
      expects($this->any())
      ->method('getBuild')
      ->with('username-in-config', 'project-name-in-config', '3')
      ->willReturn(new Build($build_info));

    $command = $this->getCommand('Codedrop\Command\ProgressCommand', $this->circle);
    $commandTester = $this->runCommand($command, ['--build-num' => '3']);
    $this->assertContains('Build has finished', $commandTester->getDisplay());
  }

  /**
   * Test the progress command bar output.
   */
  public function testProgressCommandBar() {
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

    $build1 = new Build($build_info);
    $build2 = new Build($build_info2);
    $this->circle->
    expects($this->any())
      ->method('getBuild')
      ->with('username-in-config', 'project-name-in-config', '3')
      ->willReturnOnConsecutiveCalls($build1, $build2, $build1, $build2);

    // Test the progress formatter.
    $command = $this->getCommand('Codedrop\Command\ProgressCommand', $this->circle);
    $commandTester = $this->runCommand($command, ['--build-num' => '3', '--refresh-interval' => '0.1']);

    $display_output = $commandTester->getDisplay();
    $this->assertContains('Build has finished', $display_output, 'Build marked as finished');
    $this->assertContains('Committer Name', $display_output, 'Committer name appeared in build output.');
    $this->assertContains('0/600', $display_output, 'Build started at 0 from 600 seconds.');
    $this->assertContains('600/600', $display_output, 'Build finished with ...');
    $this->assertContains('100%', $display_output);

    // Test the table formatter.
    $command = $this->getCommand('Codedrop\Command\ProgressCommand', $this->circle);
    $commandTester = $this->runCommand($command, ['--build-num' => '3', '--refresh-interval' => '0.1', '--format' => 'table']);

    $display_output = $commandTester->getDisplay();
    $this->assertContains('00:03', $display_output, 'Run time correct.');
    $this->assertContains('step_one', $display_output);
    $this->assertContains('step_two', $display_output);
  }

}
