<?php

namespace Circle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ProjectsCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'get_all_projects';
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('projects')
      ->setDescription('Get a list of all projects');
    ;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // Grab the request config and build the URL for the status command.
    $config = $this->getRequestConfig();

    // Build the endpoint URL and query Circle.
    $url = $this->buildUrl(['projects']);
    $results = $this->circle->queryCircle($url, $config);

    // Render the output as a table.
    $this->renderAsTable($results, $output);
  }

}
