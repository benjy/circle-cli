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
    $results = $this->circle->cancelBuild($this->getUsername($input), $this->getProjectName($input), $this->getLastStartedRunningBuild($input));

    // Render the output as a table.
    $this->renderAsTable([$results], $output);
    $this->finished();
  }

  /**
   * Get the build number for the last started, running build.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   The input object from the console.
   *
   * @return int
   *   The build number to use.
   *
   * @throws \Exception
   */
  protected function getLastStartedRunningBuild(InputInterface $input) {
    $build_number = $input->getOption('build-num');
    if ($build_number === 'latest') {
      $project_name = $this->getProjectName($input);
      $results = $this->circle->getRecentBuilds($this->getUsername($input), $project_name, 'running');

      if (!isset($results[0])) {
        throw new \Exception(sprintf('There are no builds running.', $project_name));
      }
      // @TODO, this is dependent on the get_recent_builds endpoint displaying
      // the build_num.
      $build_number = $results[0]['build_num'];
    }

    return $build_number;
  }

}
