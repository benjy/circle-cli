<?php

namespace Codedrop\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class StatusCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('status')
      ->setDescription('Get a project status')
      ->addArgument('project_name', InputArgument::OPTIONAL, 'Project name?');
    ;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // Grab the request config and build the URL for the status command.
    $config = $this->getConfig(['endpoints', 'get_recent_builds_single', 'request']);
    $this->validateConfig($config);

    // Get the project and username.
    $project_name = $this->getProjectName($input);
    $username = $this->getUsername();
    if (empty($username) || empty($project_name)) {
      throw new \Exception('username and project name are required for StatusCommand.');
    }

    // Build the endpoint URL and query Circle.
    $url = $this->buildUrl(['project', $username, $project_name]);
    $results = $this->circle->queryCircle($url, $config);

    // Render the output as a table.
    $this->renderAsTable($results, $output);
  }

  /**
   * {@inheritdoc}
   */
  protected function getDisplayFields() {
    return $this->getConfig(['endpoints', 'get_recent_builds_single', 'display']);
  }

  /**
   * {@inheritdoc}
   */
  protected function getRequiredRequestConfig() {
    return [
      'circle-token',
    ];
  }

}
