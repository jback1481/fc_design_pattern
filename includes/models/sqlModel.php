<?php

namespace tpt\models;


class sqlModel extends \mysqli {
  protected static $host;
  protected static $user;
  protected static $pass;
  protected static $db;
  protected static $instance;

  private $stmt;
  private $queryTypes;
  private $queryParams;


  /**
   * __construct method
   * Inits the mySQLi object
   *
   * @param string $host The hostname of the mySQL server
   * @param string $user The username of the mySQL server account
   * @param string $pass The password of the mySQL server account
   * @param string $db The database we are attempting to use
   */
  public function __construct() {
    parent::__construct(self::$host, self::$user, self::$pass, self::$db);

    if (mysqli_connect_error()) {
      die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
  }

  public function __destruct() {
    //
  }

  /**
   * getInstance method
   * Return the singleton of the mySQLi instance
   *
   * @return sqlModel $instance The singleton of the mySQLi object
   */
  public static function getInstance($host, $user, $pass, $db) {
    if (self::$instance) {
      // Instance already exists
    } else {
      // Set the DB connection credentials
      self::$host = $host;
      self::$user = $user;
      self::$pass = $pass;
      self::$db   = $db;
      // Init the instance
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * executeQuery method
   * Executes a mySQLi query and returns the result
   */
  public function executeStmt($sql, $params = array()) {
    // Init the mySQLi statement object
    $this->stmt = self::$instance->stmt_init();
    // Prepare the SQL statement
    $this->stmt->prepare($sql);

    // Do only if parameters are sent along with the SQL statement
    if (empty($params)) {
      //
    } else {
      // Dynamically bind the parameters to the mySQLi object
      // Generate your param type string (for instance "sss" for 3 string parameters)
      // For each parameter, determine it's type and map it to the predetermined mySQLi types:
      //   i - corresponding variable has type integer
      //   d - corresponding variable has type double (float)
      //   s - corresponding variable has type string
      //   b - corresponding variable is a blob and will be sent in packets

      $this->queryTypes = '';

      foreach ($params as $item) {
        switch (gettype($item)) {
          case "integer":
            $this->queryTypes .= 'i';
            break;
          case "double":
            $this->queryTypes .= 'd';
            break;
          case "string":
            $this->queryTypes .= 's';
            break;
          default:
            $this->queryTypes .= 's';
        }
      }

      // Add the type string to the query params array (passed by reference)
      $this->queryParams[] = &$this->queryTypes;
      // Add the parameters to the array (passed by reference)
      foreach ($params as $id => $term) {
        $this->queryParams[] = &$params[$id];
      }

      // Call bind_param to bind the parameters to the statement
      call_user_func_array(array($this->stmt, 'bind_param'), $this->queryParams);
      // Unset the query parameters
      unset($this->queryParams);
    }

    // Execute the query
    $this->stmt->execute();

    /*
    $stmt->store_result();
    $stmt->bind_result($column1, $column2, $column3);

    while($stmt->fetch()) {
      echo "col1=$column1, col2=$column2, col3=$column3 \n";
    }
    */

    // Close the mySQLi handle
    $this->stmt->close();
  }
}