<?php
require_once(__DIR__ . '/../locations.php');

require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresSuggestAPI extends DoloresBaseAPI {
  function get($request) {
    $key = $request['key'];
    $value = $request['value'];
    switch ($key) {
    case 'location':
      $suggestions = $this->get_location_suggestions($value);
      break;
    default:
      $this->_error('Key not found', 404);
    }

    return array('suggestions' => $suggestions);
  }

  function get_location_suggestions($value) {
    $locations = DoloresLocations::get_instance();
    return $locations->get_suggestions($value);
  }
};
