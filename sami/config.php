<?php

$iterator = Symfony\Component\Finder\Finder::create()
  ->files()
  ->name('*.php')
  ->exclude(['Console', 'Output'])
  ->in('./src');
return new Sami\Sami($iterator, [
  'theme' => 'circle',
  'title' => 'Circle CLI',
  'build_dir' => __DIR__ . '/../docs-temp',
  'cache_dir' => __DIR__ . '/cache',
  'template_dirs'        => [__DIR__ . '/theme'],
]);
