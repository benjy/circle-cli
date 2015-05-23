<?php

namespace Circle\Tests;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\EventDispatcher\EventDispatcher;

trait TestSetupTrait {

  /**
   * A helper so we can certain command methods.
   *
   * @param string $command_name
   *   The command to get a mock for.
   * @param \Circle\Circle $circle
   *   The circle service.
   *
   * @return \PHPUnit_Framework_MockObject_MockObject
   *   The mock command.
   */
  protected function getCommand($command_name, $circle, $config) {
    // Mock our command to null our the git parsing.
    $dispatcher = new EventDispatcher();
    $terminal_subscriber = $this->getMock('Circle\Notification\TerminalNotifySubscriber', ['notify', 'isTerminalNotifierAvailable']);
    $terminal_subscriber
      ->expects($this->any())
      ->method('isTerminalNotifierAvailable')
      ->willReturn(TRUE);
    $dispatcher->addSubscriber($terminal_subscriber);
    $command = $this->getMock($command_name, ['getGitRemote', 'parseGitBranch'], [$circle, $config, $dispatcher]);
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
   * @param \Circle\Config $circle_config
   *   The config object.
   * @param array $query_results
   *   The results from queryCircle.
   *
   * @return \PHPUnit_Framework_MockObject_MockObject
   *   The mock service.
   */
  protected function getCircleServiceMock($circle_config, $query_results = []) {
    $circle = $this->getMockBuilder('Circle\Circle')
      ->disableOriginalConstructor()
      ->setMethods(['queryCircle', 'getConfig'])
      ->getMock();
    if ($query_results !== FALSE) {
      $circle
        ->expects($this->any())
        ->method('queryCircle')
        ->willReturn($query_results);
    }
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
    $circle_config = $this->getMockBuilder('Circle\Config')
      ->disableOriginalConstructor()
      ->setMethods(NULL)
      ->getMock();

    $circle_config->setAll($config_array);

    return $circle_config;
  }

}
