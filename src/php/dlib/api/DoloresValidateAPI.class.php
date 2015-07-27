<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresValidateAPI extends DoloresBaseAPI {
  function get($request) {
    $key = $request['key'];
    $value = $request['value'];
    switch ($key) {
    case 'email':
      $user = get_user_by('email', $value);
      return array(
        'isValid' => $user === false
      );
    default:
      $this->_error('Key not found', 404);
    }
  }
};
