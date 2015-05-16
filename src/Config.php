<?php

namespace Circle;

use Symfony\Component\Yaml\Yaml;

class Config {

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

  protected $globalFile;
  protected $localFile;
  protected $privateFile;

  /**
   * Constructs a new circle config object.
   *
   * @param \Symfony\Component\Yaml\Yaml $parser
   *   The Yaml parser.
   * @param string $global_file
   *   The path to the global configuration file.
   * @param string $local_file
   *   The path to the local per project configuration file.
   * @param string $private_file
   *   The path to the private configuration file.
   */
  public function __construct(Yaml $parser, $global_file = '', $local_file = 'circle-cli.yml', $private_file = 'circle-cli.private.yml') {
    $this->parser = $parser;
    $global_file = empty($global_file) ? $_SERVER['HOME'] . '/circle-cli.yml' : $global_file;

    $this->setGlobalFile($global_file);
    $this->setLocalFile($local_file);
    $this->setPrivateFile($private_file);
    $this->loadConfig();
  }

  /**
   * Gets the specified config given a key.
   *
   * @param string|array $key
   *   The config key to retrieve.
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

  /**
   * Overwrite the entire loaded config.
   *
   * @param $config
   *   The new config array.
   */
  public function setAll($config) {
    $this->config = $config;
  }

  /**
   * @return array
   */
  protected function loadConfig() {
    // Grab config from any global folders.
    $global_config = $this->loadConfigFile($this->globalFile);

    // Grab config from the current folder.
    $local_config = $this->loadConfigFile($this->localFile);

    // Merge the local and global config.
    $this->config = array_replace_recursive($global_config, $local_config);

    // If there is a private configuration file for the token, merge
    // that in as well.
    $this->config = array_replace_recursive($this->config, $this->loadConfigFile($this->privateFile));

    // Make sure all endpoints have at least this config.
    $default_config = ['request' => [], 'display' => []];

    // Merge anything in the "globals" key into each endpoint configuration.
    if (isset($this->config['globals']) && isset($this->config['endpoints'])) {
      foreach ($this->config['endpoints'] as $endpoint => $endpoint_config) {

        // Merge in our default configuration.
        $this->config['endpoints'] = array_merge_recursive([$endpoint => $default_config], $this->config['endpoints']);

        // Merge the global config with the endpoint config.
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

  public function setGlobalFile($file_path) {
    $this->globalFile = $file_path;
  }

  public function setLocalFile($file_path) {
    $this->localFile = $file_path;
  }

  public function setPrivateFile($file_path) {
    $this->privateFile = $file_path;
  }
}
