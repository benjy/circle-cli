<?php

namespace Codedrop\Tests;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

// Autoloader doesn't work our test command :/
require_once "TestCommand.php";

class CommandBaseTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage circle-token is required
   */
  public function testCircleTokenRequired() {
    // Get the mock circle config and service.
    $circle_config = $this->getCircleConfigMock();
    $circle = $this->getCircleServiceMock($circle_config);

    $this->runCommand($this->getCommand('Codedrop\Tests\TestCommand', $circle));
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

    $this->runCommand($this->getCommand('Codedrop\Tests\TestCommand', $circle));
  }

  /**
   * Test the precedence selection of the username/project/build number options.
   */
  public function testCliOptions() {
    $config['endpoints']['test_command'] = [
      'request' => [
        'circle-token' => '',
        'username' => 'username-in-config',
        'project' => 'project-name-in-config',
      ],
      'display' => ['committer_name'],
    ];
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    // Test that the cli argument overrides the options in the config.
    $command = $this->getCommand('Codedrop\Tests\TestCommand', $circle);
    $command
      ->expects($this->once())
      ->method('buildUrl')
      ->with(['username-in-input', 'project-name-in-input', '3']);
    $args = [
      '--username' => 'username-in-input',
      '--project-name' => 'project-name-in-input',
      '--build-num' => '3',
    ];
    $this->runCommand($command, $args);

    // Test that the config is used when there is no username cli parameter.
    $command = $this->getCommand('Codedrop\Tests\TestCommand', $circle);
    $command
      ->expects($this->once())
      ->method('buildUrl')
      ->with(['username-in-config', 'project-name-in-config', '3']);
    $args = [
      '--build-num' => '3',
    ];
    $this->runCommand($command, $args);

    // Test that if the config and the cli input is empty, we try grab it from
    // the git remote.
    // Test that the config is used from config when there is no username cli
    // parameter.
    $config['endpoints']['test_command']['request']['username'] = '';
    $config['endpoints']['test_command']['request']['project'] = '';
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);
    $command = $this->getCommand('Codedrop\Tests\TestCommand', $circle);
    $command
      ->expects($this->any())
      ->method('getGitRemote')
      ->willReturn('git@github.com:username-in-gitremote/project-name-in-gitremote');
    $command
      ->expects($this->once())
      ->method('buildUrl')
      ->with(['username-in-gitremote', 'project-name-in-gitremote', '3']);
    $args = [
      '--build-num' => '3',
    ];
    $this->runCommand($command, $args);

    // Test that 'latest' queries the API for the last build.
    $circle = $this->getCircleServiceMock($circle_config, [['build_num' => '5']]);
    $command = $this->getCommand('Codedrop\Tests\TestCommand', $circle);
    $command
      ->expects($this->any())
      ->method('buildUrl')
      ->withConsecutive(
        [['project', 'codedrop', 'project-name']],
        [['codedrop', 'project-name', '5']]
      );
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
    $config['endpoints']['test_command']['request'] = [
      'circle-token' => '',
      'username' => 'code-drop',
    ];
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    $this->runCommand($this->getCommand('Codedrop\Tests\TestCommand', $circle));
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
        'username' => 'code-drop',
        'project' => 'Code-Drop',
      ],
      'display' => array_keys($query_results[0]),
    ];

    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, $query_results);

    $commandTester = $this->runCommand($this->getCommand('Codedrop\Tests\TestCommand', $circle));

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
    $config['endpoints']['get_recent_builds_single']['request'] = [
      'circle-token' => '',
      'username' => 'code-drop',
      'project' => 'Code-Drop'
    ];
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    $commandTester = $this->runCommand($this->getCommand('Codedrop\Command\StatusCommand', $circle));

    $this->assertContains('something', $commandTester->getDisplay());
  }

  /**
   * A helper so we can certain command methods.
   *
   * @param string $command_name
   *   The command to get a mock for.
   * @param \Codedrop\Circle $circle
   *   The circle service.
   *
   * @return \PHPUnit_Framework_MockObject_MockObject
   *   The mock command.
   */
  protected function getCommand($command_name, $circle) {
    // Mock our command to null our the git parsing.
    $command = $this->getMock($command_name, ['getGitRemote', 'buildUrl'], [$circle]);
    $command
      ->expects($this->any())
      ->method('parseGitRemote')
      ->willReturn(FALSE);

    return $command;
  }

  /**
   * Run a command and return the command tester.
   *
   * @param $command
   *   The command object.
   *
   * @return \Symfony\Component\Console\Tester\CommandTester
   *   The command tester.
   */
  protected function runCommand($command, $execute_args = []) {
    $application = new Application();
    $application->add($command);
    $command = $application->find($command->getName());
    $commandTester = new CommandTester($command);

    $execute_args += ['command' => $command->getName()];
    $commandTester->execute($execute_args);

    return $commandTester;
  }

  /**
   * Gets a mock circle service.
   *
   * @param \Codedrop\CircleConfig $circle_config
   *   The config object.
   * @param array $query_results
   *   The results from queryCircle.
   *
   * @return \PHPUnit_Framework_MockObject_MockObject
   *   The mock service.
   */
  protected function getCircleServiceMock($circle_config, $query_results = []) {
    $circle = $this->getMockBuilder('Codedrop\Circle')
      ->disableOriginalConstructor()
      ->getMock();
    $circle
      ->expects($this->any())
      ->method('queryCircle')
      ->willReturn($query_results);
    $circle
      ->expects($this->any())
      ->method('getConfig')
      ->willReturn($circle_config);

    return $circle;
  }

  /**
   * Gets a mock circle config object.
   *
   * @param array $config_array
   *   An array of configuration.
   *
   * @return \PHPUnit_Framework_MockObject_MockObject
   *   The mock circle config object.
   */
  protected function getCircleConfigMock($config_array = []) {
    $circle_config = $this->getMockBuilder('Codedrop\CircleConfig')
      ->disableOriginalConstructor()
      ->setMethods(NULL)
      ->getMock();

    $circle_config->setAll($config_array);

    return $circle_config;
  }

}
