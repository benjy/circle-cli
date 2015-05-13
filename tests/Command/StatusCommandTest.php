<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;

class StatusCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * Test the status command executes without any issues.
   */
  public function testStatusCommand() {
    $config['endpoints']['get_recent_builds'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'username-in-config',
      'project' => 'project-name-in-config',
      'display' => ['committer_name', 'subject'],
    ];
    // Get the mock circle config and service.
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, [[
      'subject' => 'this is the commit message',
      'committer_name' => 'Ben Dougherty',
      'not-displayed' => 'this should not be output'
    ]]);

    $command = $this->getCommand('Circle\Command\StatusCommand', $circle);
    $commandTester = $this->runCommand($command);

    $output = $commandTester->getDisplay();
    $this->assertContains('Ben Dougherty', $output);
    $this->assertContains('this is the commit message', $output);
    $this->assertNotContains('this should not be output', $output);
    // Assert the headings, including the order.
    $this->assertContains('| committer_name | subject', $output);
  }
}
