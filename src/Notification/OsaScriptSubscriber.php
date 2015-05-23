<?php

namespace Circle\Notification;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * OSAScript is built into core OS X and can be used to perform a number of
 * tasks including sending notifications to the user.
 *
 * @see https://developer.apple.com/library/mac/documentation/Darwin/Reference/ManPages/man1/osascript.1.html
 */
class OsaScriptSubscriber extends NotificationBase implements EventSubscriberInterface {

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
    shell_exec(sprintf("osascript -e 'display notification \"%s\" with title \"%s\"'", $title, $message));
  }

  /**
   * Gets the status for whether terminal notifier is available.
   *
   * @return bool
   *  TRUE if Osa Script is available otherwise FALSE.
   *
   * @codeCoverageIgnore
   */
  protected function isAvailable() {
    return (bool) shell_exec('which osascript');
  }

}
