<?php

namespace tpt\models;

/**
 * Class scheduleModel
 * @package tpt
 *
 * The schedule model
 */
class scheduleModel {
  protected static $model;

  private $airlistData;
  private $data;
  private $files;
  private $params;
  private $scheduleData;

  /**
   * __construct method
   */
  public function __construct() {
    // Init the mySQL connection
    require_once (BASE_PATH . '/includes/models/sqlModel.php');
    // Get the singleton instance of $model
    $this->model = \tpt\models\sqlModel::getInstance('localhost', 'root', 'jwbabc', 'tpt');
  }

  /**
   * __destruct method
   */
  public function __destruct() {
    //
  }

  public function getAirlist() {
    $this->sql = "
      SELECT
        k_airlist.fullDate airDate,
        k_airlist.channel channel,
        k_episode.episodeLength duration,
        k_episode.episodeTitle episode_title,
        k_episode.episodeGuide episode_desc,
        k_episode.cc closed_caption,
        k_episode.stereo stereo,
        k_episode.rating rating,
        k_series.seriesTitle series_title
      FROM
        k_airlist

      JOIN
        k_episode
      ON
        k_airlist.programId = k_episode.programId

      JOIN
        k_series
      ON
        k_airlist.seriesId = k_series.seriesId

      ORDER BY
        airDate";

    $this->airlistData = $this->model->executeStmt($this->sql);

    return $this->airlistData;
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
    $this->saveCSV($this->scheduleData);
  }

  /**
   * save method
   * Saves the data array to the database
   *
   * @param array $data The data object to be saved to the database
   */
  private function saveCSV($data) {
    // Microtime start
    $time_start = microtime(true);

    // First, truncate the tables
    $this->sql = "TRUNCATE TABLE k_airlist";
    $this->model->executeStmt($this->sql);
    $this->sql = "TRUNCATE TABLE k_episode";
    $this->model->executeStmt($this->sql);
    $this->sql = "TRUNCATE TABLE k_series";
    $this->model->executeStmt($this->sql);

    // Insert the data into k_airlist
    // Construct the SQL query for the prepared statement
    $this->sql = "
      INSERT INTO k_airlist(
        `fullDate`,
        `seriesId`,
        `programId`,
        `versionId`,
        `repeat`,
        `channel`
      ) VALUES (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
      )";

    // Construct the parameters for the prepared statement
    foreach($data['k_airlist'] as $k => $v) {
      foreach ($v as $column => $value) {
        if ($column === 'id') {
          // Do nothing
        } else {
          $this->params[$column] = $value;
        }
      }
      // Save the record to the DB
      $this->model->executeStmt($this->sql, $this->params);
    }

    unset($this->params);

    // Insert the data into k_episode
    $this->sql = "
      INSERT INTO k_episode(
        `seriesId`,
        `programId`,
        `versionId`,
        `episodeLength`,
        `episodeNum`,
        `episodeTitle`,
        `episodeGuide`,
        `episodeDesc`,
        `episodeUrl`,
        `cc`,
        `stereo`,
        `rating`
      ) VALUES (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
      )";

    // Construct the parameters for the prepared statement
    foreach($data['k_episode'] as $k => $v) {
      foreach ($v as $column => $value) {
        if ($column === 'id') {
          // Do nothing
        } else {
          $this->params[$column] = $value;
        }
      }
      // Save the record to the DB
      $this->model->executeStmt($this->sql, $this->params);
    }

    unset($this->params);

    // Insert the data into k_series
    $this->sql = "
      INSERT INTO k_series(
        `seriesId`,
        `seriesCode`,
        `seriesTitle`,
        `seriesDesc`,
        `seriesUrl`,
        `seriesGenre`
      ) VALUES (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
      )";

    // Construct the parameters for the prepared statement
    foreach($data['k_series'] as $k => $v) {
      foreach ($v as $column => $value) {
        if ($column === 'id') {
          // Do nothing
        } else {
          $this->params[$column] = $value;
        }
      }
      // Save the record to the DB
      $this->model->executeStmt($this->sql, $this->params);
    }

    unset($this->params);

    // Microtime end
    $time_end = microtime(true);
    $time = $time_end - $time_start;

    echo "Script executed in $time seconds\n";
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