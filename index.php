<?php
  // Initialize the session
  session_start();
  // Include the bootstrap file for the application
  require_once ('bootstrap.php');

  // Separate the paramaters into controller/action (ie ?a=support/test) from GET
  $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  // Parse the URL for routing to the correct class and method
  $params            = parse_url($url);
  $request           = explode('/', $params['path']);
  // Remove all empty values from $request
  $request           = array_filter($request);
  // Reorder the cleaned array with new keys (simpler to navigate)
  $request           = array_values($request);

  // Default to the index controller if no controller is called
  if (isset($request[0])) {
    $requestController = $request[0];
  } else {
    $requestController = 'index';
  }

  // Default to the index method of the controller if no action is called
  if (isset($request[1])) {
    $requestAction = $request[1];
  } else {
    $requestAction = 'index';
  }

  // If get variables are sent to the action, grab them and send them to the class method
  // Otherwise, set it to null
  if (isset($params['query'])) {
    parse_str($params['query'], $requestQuery);
  } else {
    $requestQuery = '';
  }

  // Require the class file
  require_once (BASE_PATH.'/includes/controllers/'.strtolower(substr($requestController, 0, 1)).substr($requestController, 1).'Controller.php');
  // Instance the class using the tpt namespace (change this to your base namespace
  $class = '\\' . 'tpt'  .'\\' . $requestController.'Controller';
  // Init the contoller class, and call the requestAction (method) on the class
  $controller = new $class();
  call_user_func_array(array($controller, $requestAction), array($requestQuery));