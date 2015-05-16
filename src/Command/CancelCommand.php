<?php

namespace Circle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command cancels either the last started build or the build specified via
 * the build-num paramter. This command uses the
 * [cancel build](https://circleci.com/docs/api#cancel-build) endpoint.
 *
 * ##### Example
 *
 *     cancel [-o|--build-num[="..."]] [-p|--project-name[="..."]] [-u|--username[="..."]]
 */
class CancelCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'cancel_build';
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('cancel')
      ->setDescription('Cancel a build.')
      ->addOption('build-num', 'o', InputOption::VALUE_OPTIONAL, 'The build number or "latest" to cancel the last build.', 'latest')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'Project name')
      ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'The project username');
    ;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $results = $this->circle->cancelBuild($this->getUsername($input), $this->getProjectName($input), $this->getBuildNumber($input));

    // Render the output as a table.
    $this->renderAsTable([$results], $output);
  }

}
