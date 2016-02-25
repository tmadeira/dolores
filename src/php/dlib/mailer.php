<?php
function dolores_mail($to, $template, $args) {
  $tpl_path = 'templates/' . DOLORES_TEMPLATE . '/' . $template;
  $template = DoloresAssets::get_static_path($tpl_path);
  if (!file_exists($template)) {
    return 0;
  }

  $message = file_get_contents($template);
  if ($message === FALSE) {
    return 0;
  }

  foreach ($args as $key => $value) {
    $message = str_replace('{' . $key . '}', $value, $message);
  }

  preg_match('|<title>(.*)</title>|', $message, $match);
  if (count($match) != 2) {
    return 0;
  }
  $subject = $match[1];

  $headers = "Content-type: text/html; charset=utf-8";
  return wp_mail($to, $subject, $message, $headers);
}
