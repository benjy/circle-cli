<?php

namespace Circle;

interface CircleInterface {

  /**
   * Query the Circle API with the given request options.
   *
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
  public function queryCircle($url, $query_args = [], $method = 'GET', $request_options = []);

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
  public function getRecentBuilds($username, $project_name);

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
  public function retryBuild($username, $project_name, $build_num, $method = 'retry');

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
  public function getBuild($username, $project_name, $build_number);

  /**
   * Gets a list of all projects.
   *
   * https://circleci.com/docs/api#projects
   *
   * @return array
   *   An array of all projects in Circle.
   */
  public function getAllProjects();

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
  public function addSshKey($username, $project_name, $private_key_file, $hostname = '');

  /**
   * Trigger a new build on a branch.
   *
   * https://circleci.com/docs/api#new-build
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
  public function triggerBuild($username, $project_name, $branch);

  /**
   * Gets the circle configuration object.
   *
   * @return \Circle\Config
   *   The circle configuration object.
   */
  public function getConfig();

}
