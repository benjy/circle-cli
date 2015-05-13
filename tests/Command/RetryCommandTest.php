<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;

class RetryCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * Test the retry command executes without any issues.
   */
  public function testRetryCommand() {
    $config['endpoints']['retry_build'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'username-in-config',
      'project' => 'project-name-in-config',
      'display' => ['committer_name', 'subject'],
    ];
    // Get the mock circle config and service.
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, [
      'committer_name' => 'Ben',
      'subject' => 'test subject',
      'hidden_field' => 'should not be output',
    ]);

    $command = $this->getCommand('Circle\Command\RetryCommand', $circle);
    $commandTester = $this->runCommand($command, ['--build-num' => '3']);

    $display = $commandTester->getDisplay();
    $this->assertContains('Ben', $display);
    $this->assertContains('test subject', $display);
    $this->assertNotContains('should not be output', $display);
  }

}
