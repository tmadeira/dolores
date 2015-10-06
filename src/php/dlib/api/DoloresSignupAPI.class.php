<?php
require_once(__DIR__ . '/../locations.php');

require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresSignupAPI extends DoloresBaseAPI {
  function post($request) {
    $phone = $request['data']['phone'];
    $email = $request['data']['email'];
    $location = $request['data']['location'];

    $auth = $request['data']['auth'];
    $user = DoloresUsers::authenticate($auth, true);

    if (array_key_exists('error', $user)) {
      $this->_error($user['error']);
    }

    $auth_field = "auth_${auth['type']}";
    $user = DoloresUsers::getUserByUniqueField($auth_field, $me['id']);

    if ($user !== null) {
      DoloresUsers::signin($user);
      return array('action' => 'refresh');
    }

    $form_errors = array();

    // Name
    $name = $user['name'];

    // Profile picture
    $picture = $user['picture'];

    // Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_errors['email'] = 'O e-mail digitado é inválido.';
    } else {
      $user_by_email = get_user_by('email', $value);
      if ($user_by_email !== false) {
        $form_errors['email'] = 'Este e-mail já está cadastrado.';
      }
    }

    // Phone
    if (strlen($phone)) {
      $phone = preg_replace('/[^0-9]/', '', $phone);
      if (strlen($phone) < 10 || strlen($phone) > 11) {
        $form_errors['phone'] = 'O telefone digitado é inválido.';
      }
    }

    // Location
    $locations = DoloresLocations::get_instance();
    if (!$locations->is_valid_location($location)) {
      $form_errors['location'] = 'Escolha uma localização válida.';
    }

    if (count($form_errors) > 0) {
      $this->_response(400, array('formErrors' => $form_errors));
    }

    $signup_data = array(
      'name' => $name,
      'picture' => $picture,
      'email' => $email,
      'phone' => $phone,
      'location' => $location,
      'auth' => array(
        'type' => $user['type'],
        'id' => $user['id']
      )
    );

    $dolores_user = DoloresUsers::signup($signup_data);

    if (array_key_exists('error', $dolores_user)) {
      $this->_error($dolores_user['error']);
    }

    DoloresUsers::signin($dolores_user);

    if (!is_user_logged_in()) {
      $this->_error('Não foi possível efetuar login.');
    }

    return array('action' => 'refresh');
  }
};
