<?php

namespace Codedrop\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class StatusCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'get_recent_builds_single';
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('status')
      ->setDescription('Get a project status')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'Project name?');
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
      throw new \Exception('username and project name are required for StatusCommand.');
    }

    // Build the endpoint URL and query Circle.
    $url = $this->buildUrl(['project', $username, $project_name]);
    $results = $this->circle->queryCircle($url, $config);

    // Render the output as a table.
    $this->renderAsTable($results, $output);
  }

}
