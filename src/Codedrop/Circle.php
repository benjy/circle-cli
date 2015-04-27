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
    $this->config = $config;
  }

  public function queryCircle($url, $args = [], $method = 'GET') {
    $url .= '?' . http_build_query($args);

    $request = $this->httpClient->createRequest($method, $url);
    $request->addHeaders(['Accept' => 'application/json']);

    return $this->httpClient
      ->send($request)
      ->json();
  }

  public function getConfig() {
    return $this->config;
  }

}
