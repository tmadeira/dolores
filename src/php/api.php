<?php
/* Template Name: Dolores API */

assert(!headers_sent());
Header('Content-Type: application/json; charset=utf-8');

require_once(DOLORES_PATH . '/dlib/api/routes.php');

if (array_key_exists('route', $_REQUEST)) {
  $route = $_REQUEST['route'];
} else {
  Header('HTTP/1.0 404');
  echo json_encode(Array('error' => 'Request missing route'));
  exit();
}

if (array_key_exists($route, $DOLORES_ROUTES)) {
  $endpoint = $DOLORES_ROUTES[$route];
} else {
  Header('HTTP/1.0 404');
  echo json_encode(Array('error' => 'Invalid route'));
  exit();
}

try {
  $API = new $endpoint($_SERVER['REQUEST_METHOD']);
  echo $API->process();
} catch (Exception $e) {
  Header('HTTP/1.0 500');
  echo json_encode(Array('error' => $e->getMessage()));
  exit();
}
