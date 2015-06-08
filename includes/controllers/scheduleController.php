<?php

  namespace tpt\controllers;

  /**
   * Class scheduleController
   * @package tpt
   *
   * Schedule controller for tpt.org
   */
  class scheduleController {

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
     * Index method
     */
    public function index() {



      // Render the view
      require_once(BASE_PATH . '/includes/views/partials/header.php');
      require_once(BASE_PATH . '/includes/views/schedule/index.php');
      require_once(BASE_PATH . '/includes/views/partials/footer.php');
    }

    /**
     * update method
     * Updates the schedule using either the PBS or CSV method
     */
    public function update($params) {
      // Init the model
      require_once (BASE_PATH . '/includes/models/scheduleModel.php');
      $model = new \tpt\models\scheduleModel();
      // Based on the passed method, update the schedule information
      switch($params['method']) {
        case 'csv':
          // Use the csv files to update the schedule
          $result = $model->update('csv');
          break;
        case 'api':
          // Use the PBS API to update the schedule
          $result = $model->update('json');
          break;
      }
    }
  }