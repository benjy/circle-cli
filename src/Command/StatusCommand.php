<?php

namespace Circle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class StatusCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'get_recent_builds';
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('status')
      ->setDescription('Get a project status')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'The project name')
      ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'The project username');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $results = $this->circle->getRecentBuilds($this->getUsername($input), $this->getProjectName($input));

    // Render the output as a table.
    $this->renderAsTable($results, $output);
  }

}
