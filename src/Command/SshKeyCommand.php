<?php

namespace Circle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command allows you to add an SSH deploy key to a project using the
 * [ssh-key](https://circleci.com/docs/api#summary) endpoint.
 *
 * #### Example
 *
 *     circle add-key [-u|--username[="..."]] [-p|--project-name[="..."]] [-f|--private-key[="..."]] [--hostname[="..."]]
 */
class SshKeyCommand extends CommandBase {

  /**
   * {@inheritdoc}
   */
  protected function getEndpointId() {
    return 'add_ssh_key';
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('add-key')
      ->setDescription('Add an SSH key to a project')
      ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'The project username')
      ->addOption('project-name', 'p', InputOption::VALUE_OPTIONAL, 'The project name')
      ->addOption('private-key', 'f', InputOption::VALUE_OPTIONAL, 'The location to the SSH private key.')
      ->addOption('hostname', NULL, InputOption::VALUE_OPTIONAL, 'The hostname for this private key.', '');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->circle->addSshKey($this->getUsername($input), $this->getProjectName($input), $this->getPrivateKey($input), $input->getOption('hostname'));
  }

  /**
   * Gets the private key path.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   The CLI input.
   *
   * @return string
   *   The path to the private key.
   *
   * @throws \InvalidArgumentException
   */
  protected function getPrivateKey(InputInterface $input) {
    if ($file = $input->getOption('private-key')) {
      return $file;
    }
    $config = $this->getEndpointConfig();
    if (empty($config['private-key'])) {
      throw new \InvalidArgumentException('You must provide the path to your private key');
    }

    return $config['private-key'];
  }

}
