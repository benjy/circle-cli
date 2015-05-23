<?php

namespace Circle\Notification;

use Circle\Command\CommandInterface;
use Circle\Event\CommandFinishedEvent;

abstract class NotificationBase {

  abstract protected function isAvailable();
  abstract protected function notify($title, $message);

  /**
   * The command finished event callback.
   *
   * @param \Circle\Event\CommandFinishedEvent $event
   *   The command finished event.
   */
  public function onCommandFinished(CommandFinishedEvent $event) {
    $command = $event->getCommand();
    if ($this->isAvailable() && $command->notificationsEnabled()) {
      $this->notify($this->getTitle($command), $command->getResultMessage());
    }
  }

  /**
   * Gets the formatted title for the notification.
   *
   * @param \Circle\Command\CommandInterface $command
   *   The Symfony command object that has completed.
   *
   * @return string
   *   The formatted title to be displayed.
   */
  protected function getTitle(CommandInterface $command) {
    $class_name = (new \ReflectionClass($command))->getShortName();
    return sprintf('%s finished', $class_name);
  }

  /**
   * Returns an array of event names this subscriber wants to listen to.
   *
   * The array keys are event names and the value can be:
   *
   *  * The method name to call (priority defaults to 0)
   *  * An array composed of the method name to call and the priority
   *  * An array of arrays composed of the method names to call and respective
   *    priorities, or 0 if unset
   *
   * For instance:
   *
   *  * array('eventName' => 'methodName')
   *  * array('eventName' => array('methodName', $priority))
   *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
   *
   * @return array The event names to listen to
   *
   * @api
   */
  public static function getSubscribedEvents() {
    return [
      'command.finished' => ['onCommandFinished', 0],
    ];
  }

}
