<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;

class BuildCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * Test the build command executes without any issues.
   */
  public function testBuildCommand() {
    $config['endpoints']['trigger_build'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'username-in-config',
      'project' => 'project-name-in-config',
      'branch' => 'master',
      'display' => ['committer_name'],
    ];

    // Test using file config.
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, FALSE);
    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->with('project/username-in-config/project-name-in-config/tree/master', ['circle-token' => ''], 'POST')
      ->willReturn([]);
    $command = $this->getCommand('Circle\Command\BuildCommand', $circle);
    $this->runCommand($command);

    // Test using CLI args.
    $circle = $this->getCircleServiceMock($circle_config, FALSE);
    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->with('project/username-in-config/project-name-in-config/tree/staging', ['circle-token' => ''], 'POST')
      ->willReturn([]);
    $command = $this->getCommand('Circle\Command\BuildCommand', $circle);
    $this->runCommand($command, [
      '--branch' => 'staging',
    ]);

    // Test using values parsed from Git.
    unset($config['endpoints']['trigger_build']['branch']);
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, FALSE);
    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->with('project/username-in-config/project-name-in-config/tree/uat', ['circle-token' => ''], 'POST')
      ->willReturn([]);
    $command = $this->getCommand('Circle\Command\BuildCommand', $circle);
    $command
      ->expects($this->once())
      ->method('parseGitBranch')
      ->willReturn('uat');
    $this->runCommand($command);
  }

  /**
   * Test the command output.
   */
  public function testBuildCommandOutput() {
    $config['endpoints']['trigger_build'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'username-in-config',
      'project' => 'project-name-in-config',
      'branch' => 'master',
      'display' => ['build_num', 'build_url', 'subject', 'branch'],
    ];

    // Test using file config.
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, FALSE);
    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->with('project/username-in-config/project-name-in-config/tree/master', ['circle-token' => ''], 'POST')
      ->willReturn(['build_num' => '5', 'build_url' => 'https://example.com/build/url', 'subject' => 'commit message', 'branch' => 'master', 'hidden' => 'should not be output']);
    $command = $this->getCommand('Circle\Command\BuildCommand', $circle);
    $commandTester = $this->runCommand($command);
    $output = $commandTester->getDisplay();
    $this->assertContains('5', $output);
    $this->assertContains('https://example.com/build/url', $output);
    $this->assertContains('commit message', $output);
    $this->assertContains('master', $output);
    $this->assertNotContains('should not be output', $output);
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage branch is required
   */
  public function testBuildCommandWithoutBranch() {
    $config['endpoints']['trigger_build'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'username-in-config',
      'project' => 'project-name-in-config',
      'display' => ['committer_name'],
    ];

    // Test using file config.
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, FALSE);
    $command = $this->getCommand('Circle\Command\BuildCommand', $circle);
    $this->runCommand($command);
  }

}
