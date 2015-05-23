<?php

namespace Circle\Notification;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * terminal-notifier is a command-line tool to send Mac OS X User Notifications,
 * which are available in Mac OS X 10.8 and higher.
 *
 * @see https://github.com/alloy/terminal-notifier
 */
class TerminalNotifySubscriber extends NotificationBase implements EventSubscriberInterface {

  /**
   * Notify the user using the terminal-notifier gem.
   *
   * @param string $title
   *   The title of the notification.
   * @param string $message
   *   The command to execute to notify the user.
   *
   * @codeCoverageIgnore
   */
  protected function notify($title, $message) {
    shell_exec(sprintf('terminal-notifier -title "%s" -message "%s"', $title, $message));
  }

  /**
   * Gets the status for whether terminal notifier is available.
   *
   * @return bool
   *  TRUE if terminal-notifier is enable otherwise FALSE.
   *
   * @codeCoverageIgnore
   */
  protected function isAvailable() {
    return (bool) shell_exec('which terminal-notifier');
  }

}
