<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresTestAPI extends DoloresBaseAPI {
  function get($request) {
    return $request;
  }
};
