<?php
require_once(DOLORES_PATH . '/dlib/mailer.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresSubscribeAPI extends DoloresBaseAPI {
  function post($request) {
    $email = $request['data']['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->_error('O e-mail digitado é inválido.');
    }

    $phone = '';
    if (array_key_exists('phone', $request['data'])) {
      $phone = $request['data']['phone'];
    }

    $location = '';
    if (array_key_exists('location', $request['data'])) {
      $location = $request['data']['location'];
    }

    $origin = 'Sidebar';
    if (array_key_exists('origin', $request['data'])) {
      $origin = $request['data']['origin'];
    }

    DoloresMailer::subscribe(array(
      'type' => 'subscriber',
      'email' => $email,
      'origin' => $origin,
      'phone' => $phone,
      'bairro' => $bairro
    ));

    return array();
  }
};
