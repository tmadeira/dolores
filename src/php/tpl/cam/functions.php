<?php
session_start();

if ($_SERVER['QUERY_STRING'] == 'ativar') {
  $_SESSION['active'] = true;
} else if ($_SERVER['QUERY_STRING'] == 'desativar') {
  $_SESSION['active'] = false;
}

if (!$_SESSION['active']) {
  die("Em breve.");
}

add_image_size('grid-thumbnail', 350, 230, true);
require_once(DOLORES_TEMPLATE_PATH . '/grid.php');
require_once(DOLORES_TEMPLATE_PATH . '/grid-ideias.php');

define('CALENDAR_ID', '4spn2cn6gpde1jf0mpdu34ti7s@group.calendar.google.com');

function dolores_random_orderby() {
  return "RAND()";
}
