<?php
require_once(__DIR__ . '/../users.php');

require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresSigninAPI extends DoloresBaseAPI {
  function post($request) {
    $me = DoloresUsers::authenticate($request);

    if (array_key_exists('error', $me)) {
      $this->_error($me['error']);
    }

    $auth_field = "auth_${request['type']}";
    $user = DoloresUsers::getUserByUniqueField($auth_field, $me['id']);

    if ($user !== null) {
      DoloresUsers::signin($user);
      return array('action' => 'refresh');
    }

    return array('action' => 'signup', 'data' => $me);
  }
};
