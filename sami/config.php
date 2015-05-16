<?php

$iterator = Symfony\Component\Finder\Finder::create()
  ->files()
  ->name('*.php')
  ->exclude(['Console', 'Output'])
  ->in('./src');
return new Sami\Sami($iterator, [
  'theme' => 'circle',
  'build_dir' => __DIR__ . '/docs',
  'cache_dir' => __DIR__ . '/sami/cache',
  'template_dirs'        => [__DIR__ . '/sami/theme'],
]);
