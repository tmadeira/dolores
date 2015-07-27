<?php
require_once(__DIR__ . '/../locations.php');

require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresValidateAPI extends DoloresBaseAPI {
  function get($request) {
    $key = $request['key'];
    $value = $request['value'];
    switch ($key) {
    case 'email':
      $isValid = $this->is_valid_email($value);
      break;
    case 'location':
      $isValid = $this->is_valid_location($value);
      break;
    default:
      $this->_error('Key not found', 404);
    }

    return array('isValid' => $isValid);
  }

  function is_valid_email($value) {
    $user = get_user_by('email', $value);
    return $user === false;
  }

  function is_valid_location($value) {
    $locations = DoloresLocations::get_instance();
    return $locations->is_valid_location($value);
  }
};
