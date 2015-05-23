<?php

namespace Circle\Event;

use Circle\Command\CommandInterface;
use Symfony\Component\EventDispatcher\Event;

class CommandEventBase extends Event {

  /**
   * @var \Symfony\Component\Console\Command\Command
   */
  protected $command;

  /**
   * Constructs a new command based event.
   *
   * @param \Circle\Command\CommandInterface
   *   The command object.
   */
  public function __construct(CommandInterface $command) {
    $this->command = $command;
  }

  /**
   * @return \Circle\Command\CommandInterface
   */
  public function getCommand() {
    return $this->command;
  }

}
