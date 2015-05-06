<?php

namespace Circle\Tests\Command;

use Circle\Command\CommandBase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('test_command')
      ->setDescription('Get a project status')
      ->addOption('build-num', 'b', InputOption::VALUE_OPTIONAL, 'The build number or "latest" to retry the last build.', 'latest')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'The project name')
      ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'The project username');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln(implode(',', [$this->getUsername($input), $this->getProjectName($input), $this->getBuildNumber($input)]));
    $results = $this->circle->queryCircle('', []);
    $this->renderAsTable($results, $output);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'test_command';
  }

}
