<?php

namespace Codedrop\Tests\Circle;

use Codedrop\Circle\Config;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Yaml\Yaml;

class ConfigTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test our config getter.
   */
  public function testNestedGet() {
    $config = $this->getMockBuilder('Codedrop\Circle\Config')
      ->disableOriginalConstructor()
      ->setMethods(NULL)
      ->getMock();
    $config->setAll([
      'key1' => 'value',
      'key2' => ['key2_1' => 'key 2 nested value'],
      'key3' => ['key3_1' => ['key3_2' => 'key 3 nested value']]
    ]);

    // Test using nested arrays and plain string keys.
    $this->assertEquals('value', $config->get('key1'));
    $this->assertEquals('value', $config->get(['key1']));
    $this->assertEquals('key 2 nested value', $config->get(['key2', 'key2_1']));
    $this->assertEquals('key 3 nested value', $config->get(['key3', 'key3_1', 'key3_2']));
  }

  /**
   * Test the config file loading.
   */
  public function testLoadOrder() {

    // Set our global config.
    $yml = 'globals:
      username: global-user-name
      project: global-project-name';
    $vfs_root = vfsStream::setup();
    vfsStream::newFile('global.yml')->at($vfs_root)->withContent($yml);

    // Set our local project config.
    $yml = 'globals:
      project: local-project-name
endpoints:
  get_projects:
    request:
      limit: 3';
    vfsStream::newFile('local.yml')->at($vfs_root)->withContent($yml);

    // Set our private config.
    $yml = 'globals:
      request:
        circle-token: private-token';
    vfsStream::newFile('private.yml')->at($vfs_root)->withContent($yml);

    $global = $vfs_root->url() . '/global.yml';
    $local = $vfs_root->url() . '/local.yml';
    $private = $vfs_root->url() . '/private.yml';
    $config = new Config(new Yaml(), $global, $local, $private);
    $this->assertEquals('global-user-name', $config->get(['globals', 'username']));
    $this->assertEquals('local-project-name', $config->get(['globals', 'project']));
    $this->assertEquals('private-token', $config->get(['globals', 'request', 'circle-token']));

    // Test all config is loaded.
    $expected = [
      'globals' => [
        'username' => 'global-user-name',
        'project' => 'local-project-name',
        'request' => [
          'circle-token' => 'private-token',
        ],
      ],
      'endpoints' => [
        'get_projects' => [
          'username' => 'global-user-name',
          'project' => 'local-project-name',
          'request' => [
            'limit' => '3',
            'circle-token' => 'private-token',
          ],
        ],
      ],
    ];
    $this->assertEquals($expected, $config->getAll());
    $this->assertEquals([], (new Config(new Yaml(), 'doesnt-exist', 'doesnt-exist', 'doesnt-exist'))->getAll());
  }

}
