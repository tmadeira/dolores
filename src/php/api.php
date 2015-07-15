<?php
/* Template Name: Dolores API */

assert(!headers_sent());
Header('Content-Type: application/json; charset=utf-8');

require_once(__DIR__ . '/dlib/api/routes.php');

try {
  if (!array_key_exists('route', $_REQUEST)) {
    Header('HTTP/1.0 404');
    echo json_encode(Array('error' => 'Request missing route'));
    exit();
  }

  $route = $_REQUEST['route'];
  if (!array_key_exists($route, $DOLORES_ROUTES)) {
    Header('HTTP/1.0 404');
    echo json_encode(Array('error' => 'Invalid route'));
    exit();
  }

  $endpoint = $DOLORES_ROUTES[$route];
  $API = new $endpoint($_SERVER['REQUEST_METHOD']);
  echo $API->process();
} catch (Exception $e) {
  Header('HTTP/1.0 500');
  echo json_encode(Array('error' => $e->getMessage()));
  exit();
}
