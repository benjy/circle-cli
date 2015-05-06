<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;

class CommandBaseTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage circle-token is required
   */
  public function testCircleTokenRequired() {
    // Get the mock circle config and service.
    $circle_config = $this->getCircleConfigMock();
    $circle = $this->getCircleServiceMock($circle_config);

    $this->runCommand($this->getCommand('Circle\Tests\Command\TestCommand', $circle));
  }

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

  /**
   * Test the generated table output.
   */
  public function testTableOutput() {
    $query_results = [
      [
        'build_num' => "123",
        'committer_name' => 'Ben',
        'subject' => 'New build',
        'branch' => 'master',
        'status' => 'failed',
      ],
    ];

    // Get the mock circle config and service.
    $config['endpoints']['test_command'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'code-drop',
      'project' => 'Code-Drop',
      'display' => array_keys($query_results[0]),
    ];

    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, $query_results);

    $commandTester = $this->runCommand($this->getCommand('Circle\Tests\Command\TestCommand', $circle));

    // Assert that all the keys and values appear in the output.
    $displayed_content = $commandTester->getDisplay();
    foreach ($query_results as $result) {
      foreach ($result as $key => $value) {
        $this->assertContains($key, $displayed_content);
        $this->assertContains($value, $displayed_content);
      }
    }
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage must provide at least one display field
   */
  public function testDisplayFieldsRequired() {
    // Get the mock circle config and service.
    $config['endpoints']['test_command'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'code-drop',
      'project' => 'Code-Drop',
    ];
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    $command = $this->getCommand('Circle\Tests\Command\TestCommand', $circle);
    $commandTester = $this->runCommand($command, ['--build-num' => '3']);

    $this->assertContains('something', $commandTester->getDisplay());
  }

}
