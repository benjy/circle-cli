<?php

namespace Circle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command provides a list of all projects within your Circle CI account.
 *
 * ##### Example
 *
 *     circle projects
 */
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
    $this->renderAsTable($this->circle->getAllProjects(), $output);
  }

}
