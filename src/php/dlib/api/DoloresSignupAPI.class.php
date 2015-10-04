<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresSignupAPI extends DoloresBaseAPI {
  function post($request) {
    $name = $request['data']['name'];
    $phone = $request['data']['phone'];
    $email = $request['data']['email'];
    $location = $request['data']['location'];

    $user = DoloresUsers::authenticate($request['data']['auth']);

    if (array_key_exists('error', $user)) {
      $this->_error($user['error']);
    }

    return array('todo-signup' => $user); // TODO
  }
};
