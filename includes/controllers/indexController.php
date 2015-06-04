<?php

  namespace tpt;

  /**
   * Class indexController
   * @package tpt
   *
   * Index controller for tpt.org
   */
  class indexController {
    public function index(){

      // Render the view
      require_once(BASE_PATH . '/includes/views/partials/header.php');
      require_once(BASE_PATH . '/includes/views/index.php');
      require_once(BASE_PATH . '/includes/views/partials/footer.php');
    }
  }