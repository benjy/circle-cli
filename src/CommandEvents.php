<?php

namespace Circle;

/**
 * Documents available events.
 */
final class CommandEvents {

  /**
   * This event fires when a command completes. The event is only triggered upon
   * completion of the command and therefore it is not fired when exceptions
   * are thrown which propagate back to the terminal.
   */
  const COMMAND_FINISHED = 'command.finished';

}
