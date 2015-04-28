<?php

namespace Codedrop\Tests;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

abstract class CommandBaseTest extends \PHPUnit_Framework_TestCase {

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
    $command = $this->getMock($command_name, ['parseGitRemote'], [$circle]);
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
  protected function runCommand($command) {
    $application = new Application();
    $application->add($command);
    $command = $application->find($command->getName());
    $commandTester = new CommandTester($command);
    $commandTester->execute(array('command' => $command->getName()));

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
