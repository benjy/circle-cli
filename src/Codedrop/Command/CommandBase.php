<?php

namespace Codedrop\Command;

use Symfony\Component\Console\Command\Command;
use Codedrop\Circle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class CommandBase extends Command {

  /**
   * The Circle CI service.
   *
   * @var \Codedrop\Circle
   */
  protected $circle;

  /**
   * The base url for the API.
   *
   * @var string
   */
  protected $baseUrl;

  /**
   * Username and project name from the Git remote.
   *
   * @var array
   */
  protected $gitRemoteParts;

  /**
   * Constructs a new command.
   *
   * @param \Codedrop\Circle $circle
   *   The circle CI service.
   * @param null|string $name
   *   The name of this command.
   */
  public function __construct(Circle $circle, $name = null) {
    parent::__construct($name);
    $this->circle = $circle;
    $this->baseUrl = 'https://circleci.com/api/v1';
  }

  /**
   * Render the endpoint results as a table.
   *
   * @param array $results
   *   An array of results to be rendered as a table.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   The output interface to render the table on.
   */
  protected function renderAsTable(array $results, OutputInterface $output) {
    $rows = [];
    $display_fields = $this->getDisplayFields();
    foreach ($results as $result) {
      $data = [];
      foreach ($display_fields as $i => $field) {
        // If the requested display field appears in the results then grab the
        // value.
        if (isset($result[$field])) {
          $data[] = $result[$field];
        }
        else {
          // Remove is so we don't get it in the headers.
          $output->writeln("Missing display field . $field");
          unset($display_fields[$i]);
        }
      }
      $rows[] = $data;
    }

    // Build the table and render the output.
    $table = new Table($output);
    $table
      ->setHeaders($display_fields)
      ->setRows($rows);

    $table->render();
  }

  protected function buildUrl($parts) {
    return $this->baseUrl . '/' . implode('/', $parts);
  }

  /**
   * Gets the requested configuration.
   *
   * @param string|array $key
   *   The configuration to retrieve given a key.
   *
   * @return mixed
   *   The configuration array or value.
   */
  protected function getConfig($key) {
    $config = $this->circle->getConfig()->get($key);

    return $config;
  }

  /**
   * Validate a configuration array for required keys.
   *
   * @param array $config
   *   The configuration to validate.
   *
   * @throws \Exception
   */
  protected function validateConfig($config) {
    foreach ($this->getRequiredRequestConfig() as $config_key) {
      if (!isset($config[$config_key])) {
        throw new \Exception(sprintf('%s is required for the %s. See circle.cli.yml, key: %s.', $config_key, get_class(), implode(':', $config_key)));
      }
    }
  }

  /**
   * Gets the project name, checking cli input, config and git remote.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   The input interface to check the command line input.
   *
   * @return string
   *   The project name.
   */
  protected function getProjectName(InputInterface $input) {
    // If the user specified a project name just use that.
    if ($project_name = $input->getArgument('project_name')) {
      return $project_name;
    }

    // If there is a project name in the config, use that instead.
    if ($project = $this->getConfig(['globals', 'project'])) {
      return $project;
    }

    // OK, we're getting desperate, maybe we can parse it out of the Git remote?
    list($username, $project_name) = $this->parseGitRemote();
    return $project_name;
  }

  /**
   * Gets the project username, checking config and the git remote.
   *
   * @return string
   *   The project username.
   */
  protected function getUsername() {
    // If there is a username in the config, use that instead.
    if ($project = $this->getConfig(['globals', 'username'])) {
      return $project;
    }

    // OK, we're getting desperate, maybe we can parse it out of the Git remote?
    list($username, $project_name) = $this->parseGitRemote();
    return $username;
  }

  /**
   * Attempt to parse the git remote, only currently supports Github.
   *
   * @return array|bool
   *   An array containing the username and project name or FALSE.
   */
  protected function parseGitRemote() {
    if (isset($this->gitRemoteParts)) {
      return $this->gitRemoteParts;
    }
    $url = trim(shell_exec('git config --get remote.origin.url'));
    $url = preg_replace('/^git@github.com:/', '', $url);
    $url = preg_replace('/.git$/', '', $url);
    if (strpos($url, '/') !== FALSE) {
      $this->gitRemoteParts = explode('/', $url);
      return $this->gitRemoteParts;
    }
    return FALSE;
  }

  /**
   * Gets the configuration keys that are required.
   *
   * @return array
   *   An array of required configuration for this request.
   */
  protected abstract function getRequiredRequestConfig();

  /**
   * Gets the display fields for this request.
   *
   * @return array
   *   An array of fields to display.
   */
  protected abstract function getDisplayFields();

}
