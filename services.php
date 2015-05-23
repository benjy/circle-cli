<?php

use Symfony\Component\EventDispatcher\EventDispatcher;
use Pimple\Container;
use Circle\Circle;
use Circle\Config;
use GuzzleHttp\Client;
use Symfony\Component\Yaml\Yaml;

// Register some services.
$container = new Container();
$container['guzzle'] = function(Container $container) {
  return new Client();
};
$container['parser'] = function(Container $container) {
  return new Yaml();
};
$container['config'] = function(Container $container) {
  return new Config($container['parser']);
};
$container['circle'] = function(Container $container) {
  return new Circle($container['config'], $container['guzzle']);
};
$container['dispatcher'] = function(Container $container) {
  return new EventDispatcher();
};
