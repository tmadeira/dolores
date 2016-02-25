<?php
require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresSubscribeAPI extends DoloresBaseAPI {
  function post($request) {
    $email = $request['data']['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->_error('O e-mail digitado é inválido.');
    }

    // TODO: subscribe

    return array();
  }
};
