<?php

namespace Codedrop\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class RetryCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'retry_build';
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('retry')
      ->setDescription('Retry a build.')
      ->addArgument('build_num', InputArgument::OPTIONAL, 'The build number or "latest" to retry the last build.', 'latest')
      ->addArgument('retry_method', InputArgument::OPTIONAL, 'Simply retry or retry with ssh by using "retry" or "ssh"', 'retry')
      ->addArgument('project_name', InputArgument::OPTIONAL, 'Project name?');
    ;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // Grab the request config and build the URL for the status command.
    $config = $this->getRequestConfig();

    // Get the project and username.
    $project_name = $this->getProjectName($input);
    $username = $this->getUsername();
    if (empty($username) || empty($project_name)) {
      throw new \Exception('username and project name are required for RetryCommand.');
    }

    $build_number = $input->getArgument('build_num');
    if ($build_number === 'latest') {
      $url = $this->buildUrl(['project', $username, $project_name]);
      $results = $this->circle->queryCircle($url, $this->getConfig(['endpoints', 'get_recent_builds_single', 'request']));

      if (!isset($results[0])) {
        throw new \Exception('Could not find the last build for %s, is this the first build?', $project_name);
      }
      $build_number = $results[0]['build_num'];
    }

    // Build the endpoint URL and query Circle.
    $url = $this->buildUrl(['project', $username, $project_name, $build_number, $input->getArgument('retry_method')]);
    $results = $this->circle->queryCircle($url, $config, 'POST');

    // Render the output as a table.
    $this->renderAsTable([$results], $output);
  }

}
