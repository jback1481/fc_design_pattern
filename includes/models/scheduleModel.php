<?php

namespace tpt\models;

/**
 * Class scheduleModel
 * @package tpt
 *
 * The schedule model
 */
class scheduleModel {

  private $data;
  private $db;
  private $files;
  private $mysqli;
  private $scheduleData;

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
   * Parses and structures the new schedule data and saves it to the DB
   *
   * @param string $type The method used to update the schedule data
   */
  public function update($type) {
    // Update the schedule information based on the method requested
    switch($type) {
      case 'csv':
        // Init the container array
        $this->scheduleData = array();
        // Get the list of files in the directory
        $this->files = scandir(BASE_PATH . '/uploads');

        foreach ($this->files as $k => $v) {
          // We are only looking for *.csv files in the directory
          // Remove all other files from the list
          if (strpos($v, '.csv') === false) {
            unset($this->files[$k]);
          }
        }

        // Parse the csv files and place them into an array
        foreach ($this->files as $item) {
          // Generate the lable for the data type
          $this->parts = explode('.', $item);
          $this->dataType = $this->parts[0];
          // Parse the *.csv file and place it into the master array
          $this->data = $this->parseCSV(BASE_PATH.'/uploads/'.$item, ',');
          $this->scheduleData[$this->dataType] = $this->data;
        }

        break;
      case 'api':
        break;
    }

    // Insert the parsed data into the DB
    $this->save($this->scheduleData);
  }

  /**
   * save method
   * Saves the data array to the database
   *
   * @param array $data The data object to be saved to the database
   */
  private function save($data) {
    // Init the mySQL connection
    require_once (BASE_PATH . '/includes/models/sqlModel.php');
    $this->db = new \tpt\models\sqlModel('localhost', 'root', '', 'tpt');

    foreach($data as $k => $v) {
      echo '<pre>';
      print_r($v[0]);
      echo '</pre>';
      die();
    }

    // TODO: Implement DB object/table mapping, and proper escaping of data.
    // TODO: Ensure that the stucture of the tables is kosher with our needs.

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

    $importer = new \tpt\helpers\CSVHelper($delimiter);
    $parse = $importer->get($file);

    return $parse;
  }

}