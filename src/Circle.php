<?php

namespace Circle;

use GuzzleHttp\ClientInterface;

class Circle implements CircleInterface {

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
   * {@inheritdoc}
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
   * {@inheritdoc}
   */
  public function getRecentBuilds($username, $project_name) {
    $endpoint = 'get_recent_builds';
    $url = $this->buildUrl(['project', $username, $project_name]);
    $builds = $this->queryCircle($url, $this->getQueryArgs($endpoint));

    return array_map(function($build) use ($endpoint) {
      return (new Build($build, $this->getDisplayFields($endpoint)))->toArray();
    }, $builds);
  }

  /**
   * {@inheritdoc}
   */
  public function retryBuild($username, $project_name, $build_num, $method = 'retry') {
    $endpoint = 'retry_build';
    $url = $this->buildUrl(['project', $username, $project_name, $build_num, $method]);
    $build = $this->queryCircle($url, $this->getQueryArgs($endpoint), 'POST');

    return (new Build($build, $this->getDisplayFields($endpoint)))->toArray();
  }

  /**
   * {@inheritdoc}
   */
  public function cancelBuild($username, $project_name, $build_num) {
    $endpoint = 'cancel_build';
    $url = $this->buildUrl(['project', $username, $project_name, $build_num, 'cancel']);
    $build = $this->queryCircle($url, $this->getQueryArgs($endpoint), 'POST');

    return (new Build($build, $this->getDisplayFields($endpoint)))->toArray();
  }

  /**
   * {@inheritdoc}
   */
  public function getBuild($username, $project_name, $build_number) {
    $endpoint = 'get_single_build';
    $url = $this->buildUrl(['project', $username, $project_name, $build_number]);
    try {
      $result = $this->queryCircle($url, $this->getQueryArgs($endpoint));
      return new Build($result, $this->getDisplayFields($endpoint));
    }
    catch (\Exception $e) {
      throw new \InvalidArgumentException('The build could not be found. Check your username, project name and build number.');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getAllProjects() {
    $endpoint = 'get_all_projects';
    $url = $this->buildUrl(['projects']);
    $projects = $this->queryCircle($url, $this->getQueryArgs($endpoint));

    return array_map(function($build) use ($endpoint) {
      return (new Project($build, $this->getDisplayFields($endpoint)))->toArray();
    }, $projects);
  }

  /**
   * {@inheritdoc}
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
   * {@inheritdoc}
   */
  public function triggerBuild($username, $project_name, $branch) {
    $endpoint = 'trigger_build';
    $url = $this->buildUrl(['project', $username, $project_name, 'tree', $branch]);
    $build = $this->queryCircle($url, $this->getQueryArgs($endpoint), 'POST');

    return (new Build($build, $this->getDisplayFields($endpoint)))->toArray();
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
    $endpoint_config = $this->getConfig()->get(['endpoints', $endpoint]);
    if ($endpoint_config === FALSE) {
      throw new \InvalidArgumentException(sprintf('You must have a config stub for %s endpoint in your config file', $endpoint));
    }
    return $endpoint_config['request'];
  }

  /**
   * Gets the display fields for this endpoint.
   *
   * @param string $endpoint
   *   The endpoint id.
   *
   * @return array
   *   An array of fields to be displayed for this endpoint.
   */
  protected function getDisplayFields($endpoint) {
    return $this->getConfig()->get(['endpoints', $endpoint, 'display']);
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
   * {@inheritdoc}
   */
  public function getConfig() {
    return $this->config;
  }

}
