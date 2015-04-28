<?php

namespace Codedrop;

use Symfony\Component\Yaml\Yaml;

class CircleConfig {

  /**
   * The config parser.
   *
   * @var \Symfony\Component\Yaml\Yaml
   */
  protected $parser;

  /**
   * The loaded configuration.
   *
   * @var array
   */
  protected $config;

  /**
   * Constructs a new circle config object.
   *
   * @param \Symfony\Component\Yaml\Yaml $parser
   *   The Yaml parser.
   */
  public function __construct(Yaml $parser) {
    $this->parser = $parser;
    $this->loadConfig();
  }

  /**
   * Gets the specified config given a key.
   *
   * @param string $key
   *   The config key to retrive.
   *
   * @return mixed
   */
  public function get($key) {
    if (is_array($key)) {
      return $this->getValue($this->config, $key);
    }
    if (isset($this->config[$key])) {
      return $this->config[$key];
    }
    return FALSE;
  }

  /**
   * Gets the entire config array.
   *
   * @return mixed
   *   The loaded config.
   */
  public function getAll() {
    return $this->config;
  }

  public function setAll($config) {
    $this->config = $config;
  }

  /**
   * @return array
   */
  protected function loadConfig() {
    // Grab config from any global folders.
    $global_config = $this->loadConfigFile($_SERVER['HOME'] . '/circle-cli.yml');

    // Grab config from the current folder.
    $local_config = $this->loadConfigFile('circle-cli.yml');

    // Merge the local and global config.
    $this->config = array_replace_recursive($global_config, $local_config);

    // If there is a private configuration file for the token, merge
    // that in as well.
    $this->config = array_replace_recursive($this->config, $this->loadConfigFile('circle-cli.private.yml'));

    // Merge anything in the "globals" key into each endpoint configuration.
    if (isset($this->config['globals']) && isset($this->config['endpoints'])) {
      foreach ($this->config['endpoints'] as $endpoint => $endpoint_config) {
        $this->config['endpoints'][$endpoint] = array_replace_recursive($this->config['globals'], $this->config['endpoints'][$endpoint]);
      }
    }
    return $this->config;
  }

  /**
   * Loads the YAML config file into a PHP array.
   *
   * @param string $file_path
   *   The location of the config file on disk.
   *
   * @return array
   *   The parsed config.
   */
  protected function loadConfigFile($file_path) {
    if (file_exists($file_path)) {
      $yaml = file_get_contents($file_path);
      return $this->parser->parse($yaml);
    }

    return [];
  }

  /**
   * Retrieves a value from a nested array with variable depth.
   *
   * @param array $array
   *   The array from which to get the value.
   * @param array $parents
   *   An array of parent keys of the value, starting with the outermost key.
   *
   * @return mixed
   *   The requested nested value. Possibly NULL if the value is NULL or not all
   *   nested parent keys exist. $key_exists is altered by reference and is a
   *   Boolean that indicates whether all nested parent keys exist (TRUE) or not
   *   (FALSE). This allows to distinguish between the two possibilities when
   *   NULL is returned.
   */
  protected function getValue(array $array, array $parents) {
    $ref = &$array;
    foreach ($parents as $parent) {
      if (is_array($ref) && array_key_exists($parent, $ref)) {
        $ref = &$ref[$parent];
      }
      else {
        return FALSE;
      }
    }
    return $ref;
  }

}
