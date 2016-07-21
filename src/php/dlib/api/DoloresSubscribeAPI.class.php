<?php
require_once(DOLORES_PATH . '/dlib/mailer.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresSubscribeAPI extends DoloresBaseAPI {
  function post($request) {
    $email = '';
    if (isset($request['data']['email'])) {
      $email = $request['data']['email'];
    }

    $name = '';
    if (array_key_exists('name', $request['data'])) {
      $name = $request['data']['name'];
    }

    $phone = '';
    if (array_key_exists('phone', $request['data'])) {
      $phone = preg_replace('/[^0-9]*/', '', $request['data']['phone']);
    }

    $location = '';
    if (array_key_exists('location', $request['data'])) {
      $location = $request['data']['location'];
    }

    $origin = 'Sidebar';
    if (array_key_exists('origin', $request['data'])) {
      $origin = $request['data']['origin'];
    }

    if (isset($request['data']['check']) && $request['data']['check'] == 1) {
      $form_errors = array();

      if (!$name) {
        $form_errors['name'] = 'Digite um nome.';
      }

      $locations = DoloresLocations::get_instance();
      if (!$locations->is_valid_location($location)) {
        $form_errors['location'] = 'Escolha uma localização válida.';
      }

      if (count($form_errors) > 0) {
        $this->_response(400, array('formErrors' => $form_errors));
      }
    }

    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->_error('O e-mail digitado é inválido.');
    }

    DoloresMailer::subscribe(array(
      'type' => 'subscriber',
      'name' => $name,
      'email' => $email,
      'origin' => $origin,
      'phone' => $phone,
      'bairro' => $location
    ));

    return array();
  }
};
