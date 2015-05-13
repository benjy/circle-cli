<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;

class CommandBaseTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage username is required
   */
  public function testUsernameRequired() {
    // Get the mock circle config and service.
    $config['endpoints']['test_command']['request']['circle-token'] = '';
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    $this->runCommand($this->getCommand('Circle\Tests\Command\TestCommand', $circle));
  }

  /**
   * Test the precedence selection of the username/project/build number options.
   */
  public function testCliOptions() {
    $config['endpoints']['test_command'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'username-in-config',
      'project' => 'project-name-in-config',
      'display' => ['committer_name'],
    ];
    // Setup the get_recent_builds config which is used by getBuildNumber().
    $config['endpoints']['get_recent_builds']['display'] = ['build_num'];
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    // Test that the cli argument overrides the options in the config.
    $command = $this->getCommand('Circle\Tests\Command\TestCommand', $circle);
    $args = [
      '--username' => 'username-in-input',
      '--project-name' => 'project-name-in-input',
      '--build-num' => '3',
    ];
    $commandTester = $this->runCommand($command, $args);
    $output = $commandTester->getDisplay();
    $this->assertContains('username-in-input', $output);
    $this->assertContains('project-name-in-input', $output);
    $this->assertContains('3', $output);

    // Test that the config is used when there is no username cli parameter.
    $command = $this->getCommand('Circle\Tests\Command\TestCommand', $circle);
    $args = [
      '--build-num' => '3',
    ];
    $commandTester = $this->runCommand($command, $args);
    $output = $commandTester->getDisplay();
    $this->assertContains('username-in-config', $output);
    $this->assertContains('project-name-in-config', $output);
    $this->assertContains('3', $output);

    // Test that if the config and the cli input is empty, we try grab it from
    // the git remote.
    // Test that the config is used from config when there is no username cli
    // parameter.
    $config['endpoints']['test_command']['username'] = '';
    $config['endpoints']['test_command']['project'] = '';
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);
    $command = $this->getCommand('Circle\Tests\Command\TestCommand', $circle);
    $command
      ->expects($this->any())
      ->method('getGitRemote')
      ->willReturn('git@github.com:username-in-gitremote/project-name-in-gitremote');
    $args = [
      '--build-num' => '3',
    ];
    $commandTester = $this->runCommand($command, $args);
    $output = $commandTester->getDisplay();
    $this->assertContains('username-in-gitremote', $output);
    $this->assertContains('project-name-in-gitremote', $output);
    $this->assertContains('3', $output);

    // Test that 'latest' queries the API for the last build.
    $circle = $this->getCircleServiceMock($circle_config, [['build_num' => '5']]);
    $command = $this->getCommand('Circle\Tests\Command\TestCommand', $circle);
    $args = [
      '--build-num' => 'latest',
      '--username' => 'codedrop',
      '--project-name' => 'project-name',
    ];
    $this->runCommand($command, $args);
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage Could not find the last build for project-name, is this the first build?
   */
  public function testBuildNumberLatestFailsForFirstBuild() {
    $config['endpoints']['test_command'] = [
      'request' => [
        'circle-token' => '',
      ],
      'display' => ['committer_name'],
    ];
    $circle_config = $this->getCircleConfigMock($config);
    // Test that 'latest' queries the API for the last build.
    $circle = $this->getCircleServiceMock($circle_config, []);
    $command = $this->getCommand('Circle\Tests\Command\TestCommand', $circle);
    $args = [
      '--build-num' => 'latest',
      '--username' => 'codedrop',
      '--project-name' => 'project-name',
    ];
    $this->runCommand($command, $args);
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage project name is required
   */
  public function testProjectNameRequired() {
    // Get the mock circle config and service.
    $config['endpoints']['test_command'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'code-drop',
    ];
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    $this->runCommand($this->getCommand('Circle\Tests\Command\TestCommand', $circle));
  }

}
