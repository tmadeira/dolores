<?php
require_once(__DIR__ . '/DoloresSignupAPI.class.php');
require_once(__DIR__ . '/DoloresTestAPI.class.php');
require_once(__DIR__ . '/DoloresValidateAPI.class.php');

$DOLORES_ROUTES = Array(
  'signup' => 'DoloresSignupAPI',
  'test' => 'DoloresTestAPI',
  'validate' => 'DoloresValidateAPI'
);
