<?php

namespace Codedrop\Tests;

require_once "TestSetupTrait.php";

class StatusCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * Test the status command executes without any issues.
   */
  public function testStatusCommand() {
    $config['endpoints']['get_recent_builds_single'] = [
      'request' => [
        'circle-token' => '',
        'username' => 'username-in-config',
        'project' => 'project-name-in-config',
      ],
      'display' => ['committer_name'],
    ];
    // Get the mock circle config and service.
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    $command = $this->getCommand('Codedrop\Command\StatusCommand', $circle);
    $this->runCommand($command);
  }

}
