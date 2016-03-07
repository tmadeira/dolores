<?php
session_start();

if ($_SERVER['QUERY_STRING'] == 'ativar') {
  $_SESSION['active'] = true;
} else if ($_SERVER['QUERY_STRING'] == 'desativar') {
  $_SESSION['active'] = false;
}

if (!$_SESSION['active']) {
  die('<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#2C0E28"><meta name="mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-capable" content="yes"><title>Compartilhe a mudança</title><style>html{background:#F5BE27;color:#2C0E28;display:table;font:20px Helvetica,Arial,sans-serif;height:100%;text-align:center;width:100%;}body{display:table-cell;vertical-align:middle;}p{margin:30px 10px;}</style><link rel="icon" sizes="192x192" href="/wp-content/themes/dolores/assets/d5863899249a8067.png"></head><body><p><img style="max-width:100%;" src="/wp-content/themes/dolores/assets/0c13fba04b1d6ff7.png"></p><p>Em breve.</p></body></html>');
}

add_image_size('grid-thumbnail', 350, 230, true);
require_once(DOLORES_TEMPLATE_PATH . '/grid.php');
require_once(DOLORES_TEMPLATE_PATH . '/grid-ideias.php');

define('CALENDAR_ID', '4spn2cn6gpde1jf0mpdu34ti7s@group.calendar.google.com');

function dolores_random_orderby() {
  return "RAND()";
}
