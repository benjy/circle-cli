<?php

namespace Circle;

class Project {

  /**
   * The project info directly from the API.
   *
   * @var array
   */
  protected $projectInfo;

  /**
   * An array of fields to use when rendering this build as an array.
   *
   * @var array
   */
  protected $displayFields;

  /**
   * Construct a new Circle Build.
   *
   * @param array $project
   *   The project info.
   */
  public function __construct(array $project, $display_fields = []) {
    $this->projectInfo = $project;
    $this->displayFields = $display_fields;
  }

  /**
   * Gets the project as an array.
   *
   * @return array
   *   The filtered project info.
   */
  public function toArray() {
    $results = array_intersect_key($this->projectInfo, array_flip($this->displayFields));
    $display_fields = $this->displayFields;

    // We sort the output using the keys so the result is the same as what is
    // defined in config.
    uksort($results, function($a, $b) use ($display_fields) {
      // We don't need to check for equality because we cannot have two keys
      // with the exact same value.
      return array_search($a, $display_fields) > array_search($b, $display_fields);
    });

    return $results;
  }

}
