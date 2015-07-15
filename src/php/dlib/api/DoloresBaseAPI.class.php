<?php
abstract class DoloresBaseAPI {
  protected $method = '';

  public function __construct($method) {
    $this->method = $method;
  }

  public function process() {
    switch ($this->method) {
    case 'POST':
      if (!is_callable(Array($this, 'post'))) {
        throw new Exception('Route does not support POST.');
      }
      $this->_success($this->post($_POST));
      break;
    case 'GET':
      if (!is_callable(Array($this, 'get'))) {
        throw new Exception('Route does not support GET.');
      }
      $this->_success($this->get($_GET));
      break;
    default:
      throw new Exception('Unexpected method ' . $this->method);
    }
  }

  protected function _response($status, $data) {
    Header('HTTP/1.1 ' . $status);
    echo json_encode($data);
    exit();
  }

  protected function _success($data) {
    $this->_response(200, $data);
  }

  protected function _error($message, $status = 500) {
    $this->_response($status, Array('error' => $message));
  }
};
