<?php

namespace Codedrop;

use GuzzleHttp\ClientInterface;

class Circle {

  /**
   * The configuration object.
   *
   * @var \Codedrop\CircleConfig
   */
  protected $config;

  /**
   * The HTTP client for querying the API.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Construct a new Circle service.
   *
   * @param \Codedrop\CircleConfig $config
   *   The configuration for this circle instance.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   */
  public function __construct(CircleConfig $config, ClientInterface $http_client) {
    $this->httpClient = $http_client;
    $this->baseUrl = 'https://circleci.com/api/v1';
    $this->config = $config;
  }

  public function queryCircle($url, $args = []) {
    //$args += ['circle-token' => $this->config->get('circle-token')];
    $url .= '?' . http_build_query($args);

    return $this->httpClient
      ->get($url, ['headers' => ['Accept' => 'application/json']])
      ->json();
  }

  public function getConfig() {
    return $this->config;
  }

}
