<?php

// Register the event subscribers.
$notification_class = $container['config']->get(['globals', 'notifications']);
if (!empty($notification_class)) {
  $container['dispatcher']->addSubscriber(new $notification_class);
}
