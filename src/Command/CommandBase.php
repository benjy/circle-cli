<?php

namespace Circle\Command;

use Circle\Circle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class CommandBase extends Command {

  /**
   * The Circle CI service.
   *
   * @var \Circle\Circle
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
   * Constructs a new command object.
   *
   * @param \Circle\Circle $circle
   *   The circle CI service.
   * @param null|string $name
   *   The name of this command.
   */
  public function __construct(Circle $circle, $name = NULL) {
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

    // Guard statement for results with no rows.
    if (!isset($results[0])) {
      return;
    }

    // Build the table and render the output.
    $table = new Table($output);
    $table
      ->setHeaders(array_keys($results[0]))
      ->setRows($results);

    $table->render();
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
   * Gets this endpoints configuration.
   *
   * @return array
   *   The configuration for this endpoint.
   */
  protected function getEndpointConfig() {
    return $this->getConfig(['endpoints', $this->getEndpointId()]);
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
    $config = $this->getEndpointConfig();
    if (!empty($config['project'])) {
      return $config['project'];
    }

    // OK, we're getting desperate, maybe we can parse it out of the Git remote?
    $git_parts = $this->parseGitRemote();

    if (!is_array($git_parts)) {
      throw new \Exception(sprintf('project name is required for %s', get_called_class()));
    }

    list(, $project_name) = $git_parts;

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
    $config = $this->getEndpointConfig();
    if (!empty($config['username'])) {
      return $config['username'];
    }

    // OK, we're getting desperate, maybe we can parse it out of the Git remote?
    $git_parts = $this->parseGitRemote();

    if (!is_array($git_parts)) {
      throw new \Exception(sprintf('username is required for %s', get_called_class()));
    }

    list($username,) = $git_parts;

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
      $results = $this->circle->getRecentBuilds($this->getUsername($input), $project_name);

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
   *
   * @codeCoverageIgnore
   */
  protected function getGitRemote() {
    return trim(shell_exec('git config --get remote.origin.url'));
  }

  /**
   * Gets the endpoint id as declared in the circle-cli.yml config.
   *
   * @return string
   *   The endpoint id.
   */
  abstract protected function getEndpointId();

}
