<?php

namespace Circle;

use GuzzleHttp\ClientInterface;

class Circle {

  /**
   * The configuration object.
   *
   * @var \Circle\Config
   */
  protected $config;

  /**
   * The HTTP client for querying the API.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * The base url for the API.
   *
   * @var string
   */
  protected $baseUrl;

  /**
   * Construct a new Circle service.
   *
   * @param \Circle\Config $config
   *   The configuration for this circle instance.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   */
  public function __construct(Config $config, ClientInterface $http_client) {
    $this->httpClient = $http_client;
    $this->config = $config;
    $this->baseUrl = 'https://circleci.com/api/v1/';
  }

  /**
   * @param string $url
   *   The url for the circle endpoint.
   * @param array $query_args
   *   An array of query arguments.
   * @param string $method
   *   The HTTP method to be used for the request.
   * @param array $request_options
   *   The Guzzle request options.
   *
   * @return array
   *   An array of results.
   */
  public function queryCircle($url, $query_args = [], $method = 'GET', $request_options = []) {
    if (!isset($query_args['circle-token'])) {
      throw new \InvalidArgumentException('The circle-token is required for all endpoints.');
    }

    $url .= '?' . http_build_query($query_args);
    $request = $this->httpClient->createRequest($method, $url, $request_options);
    $request->addHeaders(['Accept' => 'application/json']);

    return $this->httpClient
      ->send($request)
      ->json();
  }

  /**
   * Gets the most recent builds for a project.
   *
   * https://circleci.com/docs/api#recent-builds-project
   *
   * @param string $username
   *   The project username.
   * @param string $project_name
   *   The project name to retrieve the builds for.
   *
   * @return array
   *   An array of build info for the specified project.
   */
  public function getRecentBuilds($username, $project_name) {
    $url = $this->buildUrl(['project', $username, $project_name]);
    return $this->queryCircle($url, $this->getQueryArgs('get_recent_builds'));
  }

  /**
   * Retry a previous build.
   *
   * https://circleci.com/docs/api#retry-build
   *
   * @param string $username
   *   The project username.
   * @param string $project_name
   *   The project name to retry the build for.
   * @param int $build_num
   *   The build number to retry.
   * @param string $method
   *   The method to retry. Either "retry" or "ssh"
   *
   * @return array
   *   An array of build info for the restarted build.
   */
  public function retryBuild($username, $project_name, $build_num, $method = 'retry') {
    $url = $this->buildUrl(['project', $username, $project_name, $build_num, $method]);
    return $this->queryCircle($url, $this->getQueryArgs('retry_build'), 'POST');
  }

  /**
   * Gets a build from Circle.
   *
   * https://circleci.com/docs/api#build
   *
   * @param string $username
   *   The project username.
   * @param string $project_name
   *   The project name to retrieve the build for.
   * @param int $build_number
   *   The build to retrieve.
   *
   * @throws \InvalidArgumentException
   *
   * @return \Circle\Build
   *   The circle build object.
   */
  public function getBuild($username, $project_name, $build_number) {
    $url = $this->buildUrl(['project', $username, $project_name, $build_number]);
    try {
      $result = $this->queryCircle($url, $this->getQueryArgs('get_single_build'));
      return new Build($result);
    }
    catch (\Exception $e) {
      throw new \InvalidArgumentException('The build could not be found. Check your username, project name and build number.');
    }
  }

  /**
   * Gets a list of all projects.
   *
   * https://circleci.com/docs/api#projects
   *
   * @return array
   *   An array of all projects in Circle.
   */
  public function getAllProjects() {
    $url = $this->buildUrl(['projects']);
    return $this->queryCircle($url, $this->getQueryArgs('get_all_projects'));
  }

  /**
   * Add a new SSH key to a project.
   *
   * https://circleci.com/docs/api#summary
   *
   * @param string $username
   *   The username that owns the project.
   * @param string $project_name
   *   The project name to add the key.
   * @param string $private_key_file
   *   The path to the private key file that must be readable.
   * @param string $hostname
   *   The hostname for the key.
   */
  public function addSshKey($username, $project_name, $private_key_file, $hostname = '') {
    $url = $this->buildUrl(['project', $username, $project_name, 'ssh-key']);

    // Build the JSON payload into the request options.
    $request_options = [
      'json' => [
        'private_key' => file_get_contents($private_key_file),
        'hostname' => $hostname,
      ],
    ];
    $this->queryCircle($url, $this->getQueryArgs('add_ssh_key'), 'POST', $request_options);
  }

  /**
   * Trigger a new build on a branch.
   *
   * https://circleci.com/api/v1/project/:username/:project/tree/:branch?circle-token=:token
   *
   * @param string $username
   *   The username that owns the project.
   * @param string $project_name
   *   The project name to add the key.
   * @param string $branch
   *   The branch to trigger the build on.
   *
   * @return array
   *   The build info for the new build.
   */
  public function triggerBuild($username, $project_name, $branch) {
    $url = $this->buildUrl(['project', $username, $project_name, 'tree', $branch]);
    return $this->queryCircle($url, $this->getQueryArgs('trigger_build'), 'POST');
  }

  /**
   * Gets the query arguments.
   *
   * @param string $endpoint
   *   The endpoint to retrieve the configuration for.
   *
   * @return array
   *   The query arguments for this endpoint.
   */
  protected function getQueryArgs($endpoint) {
    return $this->getConfig()->get(['endpoints', $endpoint, 'request']);
  }

  /**
   * Build a URL to query.
   *
   * @param array $parts
   *   The url parts to stick together.
   *
   * @return string
   *   The fully constructed API url.
   */
  protected function buildUrl($parts) {
    return $this->baseUrl . implode('/', $parts);
  }

  /**
   * Gets the circle configuration object.
   *
   * @return \Circle\Config
   *   The circle configuration object.
   */
  public function getConfig() {
    return $this->config;
  }

}
