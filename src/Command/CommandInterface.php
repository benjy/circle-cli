<?php

namespace Circle\Command;

interface CommandInterface {

  public function notificationsEnabled();

  public function getResultMessage();
}
