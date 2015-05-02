<?php

namespace Codedrop\Command;

use Codedrop\Circle\Build;
use Codedrop\Output\TableProgressIndicator;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ProgressCommand extends CommandBase {

  /**
   * The default refresh time.
   */
  const REFRESH_INTERVAL_DEFAULT = 10;

  /**
   * A predefined list of column widths indexed by column number.
   *
   * @var array
   */
  protected $columnWidths = [
    70,
    12,
    12,
  ];

  /**
   * An array of completed steps for the table progress.
   *
   * @var array
   */
  protected $completedSteps = [];

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'get_single_build';
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('progress')
      ->setDescription('Get the progress of a single build.')
      ->addOption('build-num', 'o', InputOption::VALUE_OPTIONAL, 'The build number or "latest" to retry the last build.', 'latest')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'The project name')
      ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'The project username')
      ->addOption('refresh-interval', 'r', InputOption::VALUE_OPTIONAL, 'The refresh interval')
      ->addOption('format', 'f', InputOption::VALUE_OPTIONAL, 'The output format', 'progress');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // Grab the request config and build the URL for the status command.
    $config = $this->getRequestConfig();
    $username = $this->getUsername($input);
    $project_name = $this->getProjectName($input);
    $build_number = $this->getBuildNumber($input);

    $first_run = TRUE;
    $progress = NULL;

    do {
      // Build the endpoint URL and query Circle.
      $build = $this->circle->getBuild($username, $project_name, $build_number, $config);

      // If the build has already finished lets just render a summary. Maybe
      // we could change this behaviour later?
      if ($build->isFinished()) {
        $output->writeln('Build has already finished.');
        $this->renderAsTable([$build->toArray()], $output);
        return;
      }

      if ($input->getOption('format') === 'table') {
        if ($first_run) {
          $progress = $this->initProgressTable($build, $output);
        }
        $this->advanceProgressTable($build, $progress);
      }
      else {
        if ($first_run) {
          $progress = $this->initProgressBar($build, $output);
        }
        $this->advanceProgressBar($build, $progress);
      }

      // Sleep for the defined amount of time to avoid thrashing the API.
      sleep($this->getRefreshInterval($input));
      $first_run = FALSE;

    } while (!$build->isFinished());

    $progress->finish();
  }

  /**
   * Initialize the Symfony ProgressBar indicator.
   *
   * @param \Codedrop\Circle\Build $build
   *   The circle build.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   The console output.
   *
   * @return \Symfony\Component\Console\Helper\ProgressBar
   *   A Symfony progress bar indicator.
   */
  protected function initProgressBar(Build $build, OutputInterface $output) {
    $progress = new ProgressBar($output, $build->getPreviousSuccessfulBuildTime());
    $progress->setFormat(' %step_name% %current%/%max% [%bar%] %percent:3s%%');
    $progress->setMessage("Starting build", 'step_name');
    $progress->start();

    return $progress;
  }

  /**
   * Advance the progress bar indicator.
   *
   * @param \Codedrop\Circle\Build $build
   *   The circle build.
   * @param \Symfony\Component\Console\Helper\ProgressBar $progress
   *   The progress bar indicator to advance.
   */
  protected function advanceProgressBar(Build $build, ProgressBar $progress) {
    $status = $build->getLastActionStatus();
    $format = $this->getFormatFromStatus($status);
    $progress->setMessage($this->formatCell($format, $this->renderAtLength($build->getLastStep()->getName(), 25)), 'step_name');
    $progress->setProgress(time() - $build->getStartTime());
  }

  /**
   * Initialize a table progress indicator.
   *
   * @param \Codedrop\Circle\Build $build
   *   The circle build.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   The console output.
   *
   * @return \Codedrop\Output\TableProgressIndicator
   *   The table progress indicator.
   */
  protected function initProgressTable(Build $build, OutputInterface $output) {
    $progress = new TableProgressIndicator($output);
    $progress->setHeaders(['step', 'run time', 'status']);
    return $progress;
  }

  /**
   * Advance the table progress indicator.
   *
   * @param \Codedrop\Circle\Build $build
   *   The circle build.
   * @param \Codedrop\Output\TableProgressIndicator $progress
   *   The table progress indicator.
   */
  protected function advanceProgressTable(Build $build, TableProgressIndicator $progress) {

    // Iterator over the steps.
    foreach ($build->getSteps() as $step) {
      if (in_array($step->getName(), $this->completedSteps)) {
        continue;
      }

      $status = $step->getLastAction()->getStatus();

      // If we're still running then we calculate how long we've been running
      // this action otherwise we just use the run time give to us via circle.
      if ($step->isRunning()) {

        // Calculate the total progress in seconds and the percent complete.
        $total_progress_seconds = time() - $build->getStartTime();
        $total_progress = gmdate('i:s', $total_progress_seconds) . '/' . $build->getPreviousSuccessfulBuildTimeFormatted();
        $percent_markup = sprintf('%u%%', $total_progress_seconds / $build->getPreviousSuccessfulBuildTime() * 100);

        $cells = [$step->getName(), $total_progress, $percent_markup];
      }
      else {
        $run_time = $step->getLastAction()->getRunTime() / 1000;
        $cells = [$step->getName(), gmdate('i:s', $run_time), $status];
      }

      // Output the cell based on the status for this step.
      $row = [];
      $format = $this->getFormatFromStatus($status);
      foreach ($cells as $i => $cell) {
        $row[] = $this->formatCell($format, $this->renderAtLength($cell, $this->columnWidths[$i]));
      }
      $progress->addRow($row);
      $progress->addRow(new TableSeparator());

      // If this step is still running then we break here so it gets rendered
      // again once it's complete.
      if ($step->isRunning()) {
        break;
      }

      $this->completedSteps[] = $step->getName();
    }

    $progress->render();
  }

  /**
   * Format a cell using a CLI compatible format string.
   *
   * @param string $format
   *   The name of the format acceptable via console, eg, success, failed etc.
   * @param string $string
   *   The string to render in the cell.
   *
   * @return string
   *   The formatted string ready to be output to the console.
   */
  protected function formatCell($format, $string) {
    return sprintf("<$format>%s</$format>", $string);
  }


  /**
   * Gets a format based on the status.
   *
   * @param string $status
   *   The Circle step status.
   *
   * @return string
   *   The format string.
   */
  protected function getFormatFromStatus($status) {
    $status_formats = [
      'success' => 'info',
      'failed' => 'error',
      'running' => 'comment',
    ];
    return isset($status_formats[$status]) ? $status_formats[$status] : 'comment';
  }

  /**
   * Gets a string at an exact length, needed for consistent table output.
   *
   * @param string $string
   *   The string to render.
   * @param int $length
   *   The exact length for this string.
   *
   * @return string
   *   The string either padded or truncated.
   */
  protected function renderAtLength($string, $length) {
    return substr(str_pad($string, $length, ' '), 0, $length);
  }

  /**
   * Gets the refresh interval.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   The cli input.
   *
   * @return int
   *   The refresh interval.
   */
  protected function getRefreshInterval(InputInterface $input) {
    // If the user passed an interval in, use that first.
    if ($refresh = $input->getOption('refresh-interval')) {
      return $refresh;
    }

    // Check the configuration.
    $config = $this->getConfig(['endpoints', $this->getEndpointId(), 'request']);
    if (isset($config['refresh-interval'])) {
      return $config['refresh-interval'];
    }

    // Fall back to our default.
    return static::REFRESH_INTERVAL_DEFAULT;
  }

}
