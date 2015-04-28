<?php

namespace Codedrop\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
      ->addOption('build-num', 'n', InputOption::VALUE_OPTIONAL, 'The build number or "latest" to retry the last build.', 'latest')
      ->addOption('retry-method', 'm', InputOption::VALUE_OPTIONAL, 'Simply retry or retry with ssh by using "retry" or "ssh"', 'retry')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'Project name?')
      ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'The project username');
    ;
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // Grab the request config and build the URL for the status command.
    $config = $this->getRequestConfig();

    // Build the endpoint URL and query Circle.
    $url = $this->buildUrl(['project', $this->getUsername($input), $this->getProjectName($input), $this->getBuildNumber($input), $input->getOption('retry-method')]);
    $results = $this->circle->queryCircle($url, $config, 'POST');

    // Render the output as a table.
    $this->renderAsTable([$results], $output);
  }

}
