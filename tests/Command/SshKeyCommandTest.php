<?php

namespace Circle\Tests\Command;

use Circle\Tests\TestSetupTrait;
use org\bovigo\vfs\vfsStream;

class SshKeyCommandTest extends \PHPUnit_Framework_TestCase {

  use TestSetupTrait;

  /**
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage You must provide the path to your private key
   */
  public function testSshKeyCommandKeyRequiredTest() {
    $config['commands']['add-key']['endpoint'] = 'add_ssh_key';
    $config['endpoints']['add_ssh_key'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'code-drop',
      'project' => 'project-name',
      'display' => ['committer_name'],
    ];
    $circle_config = $this->getCircleConfigMock($config);
    $circle = $this->getCircleServiceMock($circle_config);
    $command = $this->getCommand('Circle\Command\SshKeyCommand', $circle, $circle_config);
    $this->runCommand($command);
  }

  /**
   * Test a successful push.
   */
  public function testSshKeyCommandKeyTest() {
    // Setup a private key file.
    $vfs_root = vfsStream::setup();
    vfsStream::newFile('private-key-file')->at($vfs_root)->withContent('sample-private-key-contents');
    $query_args = ['circle-token' => ''];

    $config['commands']['add-key']['endpoint'] = 'add_ssh_key';
    $config['endpoints']['add_ssh_key'] = [
      'request' => [
        'circle-token' => '',
      ],
      'username' => 'code-drop',
      'project' => 'project-name',
      'private-key' => $vfs_root->url() . '/private-key-file',
      'display' => ['committer_name'],
    ];
    $circle_config = $this->getCircleConfigMock($config);
    $payload = [
      'json' => [
        'private_key' => 'sample-private-key-contents',
        'hostname' => 'hostname-value',
      ],
    ];
    $circle = $this->getCircleServiceMock($circle_config);
    $circle
      ->expects($this->exactly(2))
      ->method('queryCircle')
      ->with('project/code-drop/project-name/ssh-key', $query_args, 'POST', $payload);
    $command = $this->getCommand('Circle\Command\SshKeyCommand', $circle, $circle_config);

    // Test the basics of the command.
    $this->runCommand($command, [
      '--hostname' => 'hostname-value',
    ]);

    // Test again, using a CLI argument.
    $this->runCommand($command, [
      '--private-key' => $vfs_root->url() . '/private-key-file',
      '--hostname' => 'hostname-value',
    ]);
  }

}
