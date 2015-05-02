<?php

namespace Codedrop\Output;

use Symfony\Component\Console\Helper\TableSeparator;
use Console\Helper\Table;

class TableProgressIndicator extends Table {

  /**
   * TRUE for the first row only.
   *
   * @var bool
   */
  protected $firstRun = TRUE;

  /**
   * Override the render method so we can apply our own logic.
   */
  public function render() {
    // Remove the last separator and then set the rows.
    array_pop($this->rows);

    // Render the table.
    $this->doRender($this->firstRun);

    // Clear the rows.
    $this->rows = [];

    // If it's the first run, nuke the headers.
    if ($this->firstRun === TRUE) {
      $this->firstRun = FALSE;
      $this->headers = [];
    }
  }

  /**
   * Do the rendering for the current table contents.
   *
   * @param bool $render_first_separator
   *   TRUE if we want to render the first line separate otherwise FALSE.
   */
  protected function doRender($render_first_separator) {
    if ($render_first_separator === TRUE) {
      $this->renderRowSeparator();
    }

    $this->renderRow($this->headers, $this->style->getCellHeaderFormat());
    if (!empty($this->headers)) {
      $this->renderRowSeparator();
    }
    foreach ($this->rows as $row) {
      if ($row instanceof TableSeparator) {
        $this->renderRowSeparator();
      } else {
        $this->renderRow($row, $this->style->getCellRowFormat());
      }
    }
    if (!empty($this->rows)) {
      $this->renderRowSeparator();
    }
  }

  /**
   * Clean-up and reset the table.
   */
  public function finish() {
    $this->cleanup();
  }

}
