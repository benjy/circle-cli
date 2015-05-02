<?php

namespace Codedrop;

use Codedrop\Circle\Build;
use Codedrop\Circle\Config;
use GuzzleHttp\ClientInterface;

class Circle {

  /**
   * The configuration object.
   *
   * @var \Codedrop\Circle\Config
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
   * @param \Codedrop\Circle\Config $config
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
   * @param array $args
   *   An array of query arguments.
   * @param string $method
   *   The HTTP method to be used for the request.
   *
   * @return array
   *   An array of results.
   */
  public function queryCircle($url, $args = [], $method = 'GET') {
    $url .= '?' . http_build_query($args);

    $request = $this->httpClient->createRequest($method, $url);
    $request->addHeaders(['Accept' => 'application/json']);

    return $this->httpClient
      ->send($request)
      ->json();
  }

  /**
   * Gets a build from Circle.
   *
   * @param string $username
   *   The project username.
   * @param string $project_name
   *   The project name to retrieve the build for.
   * @param int $build_number
   *   The build to retrieve.
   * @param array $request_config
   *   The request configuration whey querying the API.
   *
   * @throws \InvalidArgumentException
   *
   * @return \Codedrop\Circle\Build
   *   The circle build object.
   */
  public function getBuild($username, $project_name, $build_number, $request_config = []) {
    $url = $this->buildUrl(['project', $username, $project_name, $build_number]);
    try {
      $result = $this->queryCircle($url, $request_config);
      return new Build($result);
    }
    catch (\Exception $e) {
      throw new \InvalidArgumentException('The build could not be found. Check your username, project name and build number.');
    }
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
   * @return \Codedrop\Config
   *   The circle configuration object.
   */
  public function getConfig() {
    return $this->config;
  }

}
