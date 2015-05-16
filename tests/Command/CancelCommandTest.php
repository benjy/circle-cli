<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;

class CancelCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * Test the cancel command executes without any issues.
   */
  public function testCancelCommand() {
    $config['endpoints'] = [
      'cancel_build' => [
        'request' => [
          'circle-token' => '',
        ],
        'username' => 'username-in-config',
        'project' => 'project-name-in-config',
        'display' => ['committer_name'],
      ],
    ];

    // Test using file config.
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, FALSE);
    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->with('project/username-in-config/project-name-in-config/2/cancel', ['circle-token' => ''], 'POST')
      ->willReturn([]);
    $command = $this->getCommand('Circle\Command\CancelCommand', $circle);
    $this->runCommand($command, [
      '--build-num' => 2,
    ]);

    // Test using CLI args.
    $circle = $this->getCircleServiceMock($circle_config, FALSE);
    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->with('project/username-in-config/project-name-in-config/1/cancel', ['circle-token' => ''], 'POST')
      ->willReturn([]);
    $command = $this->getCommand('Circle\Command\CancelCommand', $circle);
    $this->runCommand($command, [
      '--build-num' => 1,
    ]);
  }

//  /**
//   * Test the command output.
//   */
//  public function testBuildCommandOutput() {
//    $config['endpoints']['trigger_build'] = [
//      'request' => [
//        'circle-token' => '',
//      ],
//      'username' => 'username-in-config',
//      'project' => 'project-name-in-config',
//      'branch' => 'master',
//      'display' => ['build_num', 'build_url', 'subject', 'branch'],
//    ];
//
//    // Test using file config.
//    $circle_config = $this->getCircleConfigMock($config);
//    $circle = $this->getCircleServiceMock($circle_config, FALSE);
//    $circle
//      ->expects($this->once())
//      ->method('queryCircle')
//      ->with('project/username-in-config/project-name-in-config/tree/master', ['circle-token' => ''], 'POST')
//      ->willReturn(['build_num' => '5', 'build_url' => 'https://example.com/build/url', 'subject' => 'commit message', 'branch' => 'master', 'hidden' => 'should not be output']);
//    $command = $this->getCommand('Circle\Command\BuildCommand', $circle);
//    $commandTester = $this->runCommand($command);
//    $output = $commandTester->getDisplay();
//    $this->assertContains('5', $output);
//    $this->assertContains('https://example.com/build/url', $output);
//    $this->assertContains('commit message', $output);
//    $this->assertContains('master', $output);
//    $this->assertNotContains('should not be output', $output);
//  }

}
