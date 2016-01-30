<?php
require_once(DOLORES_PATH . '/dlib/users.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresUserHeaderAPI extends DoloresBaseAPI {
  function get($request) {
    return array('html' => DoloresUsers::getUserHeaderLi());
  }
};
