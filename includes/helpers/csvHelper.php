<?php

namespace tpt\helpers;

/*
 * CSVImporter class
 *
 * A simple class for parsing CSV files, or any text based files using a delimiter for its data
 * This class handles the following:
 * - Initializes the class and sets the delimiter for the file
 * - Gets the file and parses the data into a PHP array, with the keys being columns and the values being rows
 * - Returns the array to the caller
 */
class CSVHelper {
  private $delimiter;
  private $header;
  private $handle;
  private $data;

  /**
   * __construct method
   * Constructor method for the class
   *
   * @param string $delimiter The delimiter for data in the file
   */
  public function __construct($delimiter=",") {
    // Ensure compatibility with specifc OS line endings
    ini_set("auto_detect_line_endings", true);
    // Set the delimiter for files to be parsed
    $this->delimiter = $delimiter;
  }

  /**
   * __destruct method
   * Destructor method for the class
   */
  public function __destruct() {
    //
  }

  /**
   * get method
   * Parses the data in the file and returns it
   *
   * @param string $file The file path
   * @return array The pasrsed CSV data
   */
  public function get($file) {
    // Check if the file exists
    if(!file_exists($file) || !is_readable($file)) {
      return FALSE;
    }

    // Init a handle for the file
    $this->handle = fopen($file, 'r');
    // Init containers for data
    $this->header = NULL;
    $this->data = array();
    // Parse the CSV
    if ($this->handle !== FALSE) {
      while (($row = fgetcsv($this->handle, 0, $this->delimiter)) !== FALSE) {
        if(!$this->header) {
          $this->header = $row;
        } else {
          $this->data[] = array_combine($this->header, $row);
        }
      }

      fclose($this->handle);
    }

    return $this->data;
  }
}