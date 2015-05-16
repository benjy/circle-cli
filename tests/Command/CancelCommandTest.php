<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;

class CancelCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  protected $circleConfig;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $config['endpoints'] = [
      'cancel_build' => [
        'request' => [
          'circle-token' => '',
        ],
        'username' => 'username-in-config',
        'project' => 'project-name-in-config',
        'display' => ['committer_name'],
      ],
      'get_recent_builds' => ['request' => ['circle-token' => ''], 'display' => ['build_num']],
    ];

    // Test using file config.
    $this->circleConfig = $this->getCircleConfigMock($config);
  }

  /**
   * Test the cancel command executes without any issues.
   */
  public function testCancelCommand() {
    $circle = $this->getCircleServiceMock($this->circleConfig, FALSE);
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
    $circle = $this->getCircleServiceMock($this->circleConfig, FALSE);
    $circle
      ->expects($this->exactly(2))
      ->method('queryCircle')
      ->willReturn([['build_num' => 1]]);
    $command = $this->getCommand('Circle\Command\CancelCommand', $circle);
    $this->runCommand($command);
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage There are no builds running
   */
  public function testNoBuildsRunning() {
    $circle = $this->getCircleServiceMock($this->circleConfig, FALSE);
    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->willReturn([]);
    $command = $this->getCommand('Circle\Command\CancelCommand', $circle);
    $this->runCommand($command);
  }

}
