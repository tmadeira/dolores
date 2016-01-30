<?php
require_once(DOLORES_PATH . '/dlib/api/DoloresCommentAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresContactAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresPostAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresSigninAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresSignupAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresSuggestAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresUserHeaderAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresUserInfoAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresValidateAPI.class.php');
require_once(DOLORES_PATH . '/dlib/api/DoloresVoteAPI.class.php');

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
  'vote' => 'DoloresVoteAPI'
);
