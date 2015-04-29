<?php

namespace Codedrop\Tests;

require_once "TestSetupTrait.php";

class RetryCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * Test the retry command executes without any issues.
   */
  public function testRetryCommand() {
    $config['endpoints']['retry_build'] = [
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

    $command = $this->getCommand('Codedrop\Command\RetryCommand', $circle);
    $this->runCommand($command, ['--build-num' => '3']);
  }

}
