<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;

class ProjectsCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * Test the projects command executes without any issues.
   */
  public function testProjectsCommand() {
    $config['endpoints']['get_all_projects'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'username-in-config',
      'project' => 'project-name-in-config',
      'display' => ['reponame', 'username'],
    ];
    // Get the mock circle config and service.
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, [[
      'reponame' => 'Test Repo',
      'username' => 'code-drop',
      'hidden_field' => 'should not be output',
    ]]);

    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->willReturn(['results' => []]);

    $command = $this->getCommand('Circle\Command\ProjectsCommand', $circle);
    $commandTester = $this->runCommand($command);

    $display = $commandTester->getDisplay();
    $this->assertContains('Test Repo', $display);
    $this->assertContains('code-drop', $display);
    $this->assertNotContains('should not be output', $display);
  }

}
