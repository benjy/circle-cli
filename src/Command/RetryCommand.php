<?php

namespace Circle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command starts a "retry" of a given build using the
 * [retry-build](https://circleci.com/docs/api#retry-build) endpoint. You can
 * use "latest" to retry the last build and using the "ssh" retry-method option
 * to rebuild with SSH enabled.
 *
 * ##### Example
 *
 *     circle retry [-o|--build-num[="..."]] [-m|--retry-method[="..."]] [-p|--project-name[="..."]] [-u|--username[="..."]]
 */
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
      ->addOption('build-num', 'o', InputOption::VALUE_OPTIONAL, 'The build number or "latest" to retry the last build.', 'latest')
      ->addOption('retry-method', 'm', InputOption::VALUE_OPTIONAL, 'Simply retry or retry with ssh by using "retry" or "ssh"', 'retry')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'Project name?')
      ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'The project username');
    ;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $results = $this->circle->retryBuild($this->getUsername($input), $this->getProjectName($input), $this->getBuildNumber($input), $input->getOption('retry-method'));

    // Render the output as a table.
    $this->renderAsTable([$results], $output);
  }

}
