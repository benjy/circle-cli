<?php

namespace Circle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command allows you to trigger a new build on a given branch.
 *
 * #### Example
 *
 *     circle build [-u|--username[="..."]] [-p|--project-name[="..."]] [-b|--branch[="..."]]
 */
class BuildCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'trigger_build';
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('build')
      ->setDescription('Trigger a new build')
      ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'The project username')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'The project name')
      ->addOption('branch', 'b', InputOption::VALUE_OPTIONAL, 'The branch name');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $results = $this->circle->triggerBuild($this->getUsername($input), $this->getProjectName($input), $this->getBranch($input));
    $this->renderAsTable([$results], $output);
  }

  /**
   * Gets the branch name.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   The input interface to check the command line input.
   *
   * @return string
   *   The branch name.
   *
   * @throws \Exception
   */
  protected function getBranch(InputInterface $input) {
    if ($branch = $input->getOption('branch')) {
      return $branch;
    }

    $config = $this->getEndpointConfig();
    if (!empty($config['branch'])) {
      return $config['branch'];
    }

    // OK, we're getting desperate, maybe we can parse it out of git?
    if ($branch = $this->parseGitBranch()) {
      return $branch;
    }

    throw new \Exception(sprintf('branch is required for %s', get_called_class()));
  }

  /**
   * Try and get the repo from the current git repo.
   *
   * @return string
   *   The branch from the repo.
   *
   * @codeCoverageIgnore
   */
  protected function parseGitBranch() {
    return trim(shell_exec('git branch'));
  }

}
