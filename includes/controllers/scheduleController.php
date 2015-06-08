<?php

  namespace tpt\controllers;

  /**
   * Class scheduleController
   * @package tpt
   *
   * Schedule controller for tpt.org
   */
  class scheduleController {
    private $airlistData;
    private $model;

    /**
     * __construct method
     */
    public function __construct() {
      // Init the model
      require_once (BASE_PATH . '/includes/models/scheduleModel.php');
      $this->model = new \tpt\models\scheduleModel();
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
      $this->airlistData = $this->model->getAirlist();

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
      // Based on the passed method, update the schedule information
      switch($params['method']) {
        case 'csv':
          // Use the csv files to update the schedule
          $result = $this->model->update('csv');
          break;
        case 'api':
          // Use the PBS API to update the schedule
          $result = $this->model->update('json');
          break;
      }
    }
  }