<?php
/**
 * Created by PhpStorm.
 * User: jback
 * Date: 6/5/15
 * Time: 10:27 AM
 */

namespace tpt\models;


class sqlModel extends mysqli {
  /**
   * @param string $host The hostname of the mySQL server
   * @param string $user The username of the mySQL server account
   * @param string $pass The password of the mySQL server account
   * @param string $db The database we are attempting to use
   */
  public function __construct($host, $user, $pass, $db) {
    parent::__construct($host, $user, $pass, $db);

    if (mysqli_connect_error()) {
      die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
  }
}