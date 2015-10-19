<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');

require_once(__DIR__ . '/../users.php');

class DoloresUserHeaderAPI extends DoloresBaseAPI {
  function get($request) {
    return array('html' => DoloresUsers::getUserHeaderLi());
  }
};
