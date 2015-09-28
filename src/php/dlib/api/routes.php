<?php
require_once(__DIR__ . '/DoloresSigninAPI.class.php');
require_once(__DIR__ . '/DoloresSignupAPI.class.php');
require_once(__DIR__ . '/DoloresSuggestAPI.class.php');
require_once(__DIR__ . '/DoloresUserInfoAPI.class.php');
require_once(__DIR__ . '/DoloresValidateAPI.class.php');

$DOLORES_ROUTES = Array(
  'signin' => 'DoloresSigninAPI',
  'signup' => 'DoloresSignupAPI',
  'suggest' => 'DoloresSuggestAPI',
  'user_info' => 'DoloresUserInfoAPI',
  'validate' => 'DoloresValidateAPI'
);
