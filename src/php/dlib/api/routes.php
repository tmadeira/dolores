<?php
require_once(__DIR__ . '/DoloresCommentAPI.class.php');
require_once(__DIR__ . '/DoloresContactAPI.class.php');
require_once(__DIR__ . '/DoloresPostAPI.class.php');
require_once(__DIR__ . '/DoloresSigninAPI.class.php');
require_once(__DIR__ . '/DoloresSignupAPI.class.php');
require_once(__DIR__ . '/DoloresV1SignupAPI.class.php');
require_once(__DIR__ . '/DoloresSuggestAPI.class.php');
require_once(__DIR__ . '/DoloresUserHeaderAPI.class.php');
require_once(__DIR__ . '/DoloresUserInfoAPI.class.php');
require_once(__DIR__ . '/DoloresV1UserInfoAPI.class.php');
require_once(__DIR__ . '/DoloresValidateAPI.class.php');
require_once(__DIR__ . '/DoloresVoteAPI.class.php');

$DOLORES_ROUTES = Array(
  'comment' => 'DoloresCommentAPI',
  'contact' => 'DoloresContactAPI',
  'post' => 'DoloresPostAPI',
  'signin' => 'DoloresSigninAPI',
  'signup' => 'DoloresSignupAPI',
  'suggest' => 'DoloresSuggestAPI',
  'userheader' => 'DoloresUserHeaderAPI',
  'userinfo' => 'DoloresUserInfoAPI',
  'validate' => 'DoloresValidateAPI',
  'vote' => 'DoloresVoteAPI',
  'v1-signup' => 'DoloresV1SignupAPI',
  'v1-userinfo' => 'DoloresV1UserInfoAPI'
);
