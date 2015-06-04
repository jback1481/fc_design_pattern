<?php

namespace tpt;

/**
 * Class scheduleModel
 * @package tpt
 *
 * The schedule model
 */
class scheduleModel {
  /**
   * __construct method
   */
  public function __construct() {

  }

  /**
   * __destruct method
   */
  public function __destruct() {

  }

  /**
   * update method
   */
  public function update() {

  }

  /**
   * parseCSV method
   * Loads the CSVHelper library and parses the CSV file data into a PHP array
   *
   * @param string $file The file path
   * @param string $delimiter The delimiter for the CSV file
   *
   * @return boolean The success of the parse
   */
  private function parseCSV($file, $delimiter) {
    require_once BASE_PATH.'/includes/helpers/CSVHelper.php';

    $importer = new CSVHelper($delimiter);
    $parse = $importer->get($file);

    return $parse;
  }

}