<?php

  namespace tpt\controllers;

  /**
   * Class indexController
   * @package tpt
   *
   * Index controller for tpt.org
   */
  class indexController {
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
     * index method
     */
    public function index(){

      // Render the view
      require_once(BASE_PATH . '/includes/views/partials/header.php');
      require_once(BASE_PATH . '/includes/views/index.php');
      require_once(BASE_PATH . '/includes/views/partials/footer.php');
    }
  }