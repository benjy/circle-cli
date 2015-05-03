<?php

namespace Circle\Tests;

use Circle\Build;
use Circle\Config;
use GuzzleHttp\Client;
use Symfony\Component\Yaml\Yaml;

class CircleTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test the get build endpoint.
   */
  public function testGetBuild() {
    $config = new Config(new Yaml());
    $http_client = new Client();
    $circle = $this->getMockBuilder('Circle\Circle')
      ->setConstructorArgs([$config, $http_client])
      ->setMethods(['queryCircle'])
      ->getMock();

    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->willReturn([]);

    $build = $circle->getBuild('username', 'projectname', 'buildnum');
    $this->assertTrue($build instanceof Build);
    $this->assertTrue($circle->getConfig() === $config);
  }

  /**
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage The build could not be found. Check your username, project name and build number.
   */
  public function testGetBuildFail() {
    $circle = $this->getMockBuilder('Circle\Circle')
      ->disableOriginalConstructor()
      ->setMethods(['queryCircle'])
      ->getMock();

    $circle
      ->expects($this->once())
      ->method('queryCircle')
      ->willReturnCallback(function() {
        throw new \Exception('Some kind of curl error');
      });
    $circle->getBuild('username', 'projectname', 'buildnum');
  }
}
