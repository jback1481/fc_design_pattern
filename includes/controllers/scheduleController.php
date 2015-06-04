<?php

  namespace tpt;

  /**
   * Class scheduleController
   * @package tpt
   *
   * Schedule controller for tpt.org
   */
  class scheduleController {

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

      switch($params['method']) {
        case 'csv':
          echo 'The CSV method will be used';



          break;
        case 'api':
          echo 'The API method will be used';
          break;
      }
    }
  }