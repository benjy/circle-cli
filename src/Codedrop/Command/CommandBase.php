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
    $this->baseUrl = 'https://circleci.com/api/v1/';
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
    return $this->baseUrl . implode('/', $parts);
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
   * Gets the request config for this endpoint.
   *
   * @return mixed
   *   The configuration array or value.
   *
   * @throws \Exception
   */
  protected function getRequestConfig() {
    $config = $this->getConfig(['endpoints', $this->getEndpointId(), 'request']);
    $this->validateConfig($config);
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
        throw new \Exception(sprintf('%s is required for the %s. See circle.cli.yml, key: %s.', $config_key, get_called_class(), $config_key));
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
   *
   * @throws \Exception
   */
  protected function getProjectName(InputInterface $input) {
    // If the user specified a project name just use that.
    if ($project_name = $input->getOption('project-name')) {
      return $project_name;
    }

    // If there is a project name in the config, use that instead.
    if ($project = $this->getConfig(['endpoints', $this->getEndpointId(), 'request', 'project'])) {
      return $project;
    }

    // OK, we're getting desperate, maybe we can parse it out of the Git remote?
    list($username, $project_name) = $this->parseGitRemote();

    if (empty($project_name)) {
      throw new \Exception(sprintf('project name is required for %s', get_called_class()));
    }

    return $project_name;
  }

  /**
   * Gets the project username, checking config and the git remote.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   The input interface to check the command line input.
   *
   * @return string
   *   The project username.
   *
   * @throws \Exception
   */
  protected function getUsername(InputInterface $input) {
    // If the user specified a username just use that.
    if ($username = $input->getOption('username')) {
      return $username;
    }

    // If there is a username in the config, use that instead.
    if ($username = $this->getConfig(['endpoints', $this->getEndpointId(), 'request', 'username'])) {
      return $username;
    }

    // OK, we're getting desperate, maybe we can parse it out of the Git remote?
    $git_parts = $this->parseGitRemote();

    if (!is_array($git_parts)) {
      throw new \Exception(sprintf('username is required for %s', get_called_class()));
    }

    list($username, $project_name) = $git_parts;

    return $username;
  }

  /**
   * Check if the build number is the special "latest" and if so, grab the
   * last build from the API.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   The input object from the console.
   *
   * @return int
   *   The build number to use.
   *
   * @throws \Exception
   */
  protected function getBuildNumber(InputInterface $input) {
    $build_number = $input->getOption('build-num');
    if ($build_number === 'latest') {
      $project_name = $this->getProjectName($input);
      $url = $this->buildUrl(['project', $this->getUsername($input), $project_name]);
      $results = $this->circle->queryCircle($url, $this->getConfig(['endpoints', 'get_recent_builds_single', 'request']));

      if (!isset($results[0])) {
        throw new \Exception(sprintf('Could not find the last build for %s, is this the first build?', $project_name));
      }
      $build_number = $results[0]['build_num'];
    }

    return $build_number;
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
    $url = $this->getGitRemote();
    $url = preg_replace('/^git@github.com:/', '', $url);
    $url = preg_replace('/.git$/', '', $url);
    if (strpos($url, '/') !== FALSE) {
      $this->gitRemoteParts = explode('/', $url);
      return $this->gitRemoteParts;
    }
    return FALSE;
  }

  /**
   * Gets the git remote for this project.
   *
   * @return string
   *   Get the git remote.
   */
  protected function getGitRemote() {
    return trim(shell_exec('git config --get remote.origin.url'));
  }

  /**
   * Gets the configuration keys that are required.
   *
   * @return array
   *   An array of required configuration for this request.
   */
  protected function getRequiredRequestConfig() {
    return [
      'circle-token',
    ];
  }

  /**
   * Gets the display fields for this request.
   *
   * @return array
   *   An array of fields to display.
   *
   * @throws \Exception
   */
  protected function getDisplayFields() {
    $display_fields = $this->getConfig(['endpoints', $this->getEndpointId(), 'display']);
    if (empty($display_fields)) {
      throw new \Exception(sprintf('Command %s must provide at least one display field.', get_called_class()));
    }
    return $display_fields;
  }

  /**
   * Gets the endpoint id as declared in the circle-cli.yml config.
   *
   * @return string
   *   The endpoint id.
   */
  abstract protected function getEndpointId();

}
