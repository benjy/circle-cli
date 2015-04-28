<?php

namespace Codedrop\Tests;

class StatusCommandTest extends CommandBaseTest {

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage circle-token is required
   */
  public function testCircleTokenRequired() {
    // Get the mock circle config and service.
    $circle_config = $this->getCircleConfigMock();
    $circle = $this->getCircleServiceMock($circle_config);

    $this->runCommand($this->getCommand($circle));
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage username is required
   */
  public function testUsernameRequired() {
    // Get the mock circle config and service.
    $config['endpoints']['get_recent_builds_single']['request']['circle-token'] = '';
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    $this->runCommand($this->getCommand($circle));
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage project name is required
   */
  public function testProjectNameRequired() {
    // Get the mock circle config and service.
    $config['endpoints']['get_recent_builds_single']['request'] = [
      'circle-token' => '',
      'username' => 'code-drop',
    ];
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);

    $this->runCommand($this->getCommand($circle));
  }

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
    $config['endpoints']['get_recent_builds_single'] = [
      'request' => [
        'circle-token' => '',
        'username' => 'code-drop',
        'project' => 'Code-Drop',
      ],
      'display' => array_keys($query_results[0]),
    ];

    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config, $query_results);

    $commandTester = $this->runCommand($this->getCommand($circle));

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

    $commandTester = $this->runCommand($this->getCommand($circle));

    $this->assertContains('something', $commandTester->getDisplay());
  }

  /**
   * A helper so we can certain command methods.
   *
   * @param \Codedrop\Circle $circle
   *   The circle service.
   *
   * @return \PHPUnit_Framework_MockObject_MockObject
   *   The mock command.
   */
  protected function getCommand($circle) {
    // Mock our command to null our the git parsing.
    $command = $this->getMock('Codedrop\Command\StatusCommand', ['parseGitRemote'], [$circle]);
    $command
      ->expects($this->any())
      ->method('parseGitRemote') //null
      ->willReturn(FALSE);

    return $command;
  }

}
