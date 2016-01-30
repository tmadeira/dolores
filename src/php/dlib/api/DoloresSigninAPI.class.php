<?php
require_once(DOLORES_PATH . '/dlib/users.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresSigninAPI extends DoloresBaseAPI {
  function post($request) {
    $me = DoloresUsers::authenticate($request);

    if (array_key_exists('error', $me)) {
      $this->_error($me['error']);
    }

    if (!$me['id']) {
      $this->_error('Erro na autenticação.');
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
