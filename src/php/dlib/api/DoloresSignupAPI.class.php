<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');
require_once(__DIR__ . '/../wp_util/user_meta.php');

class DoloresSignupAPI extends DoloresBaseAPI {
  function post($request) {
    $email = $request['email'];
    $location = $request['location'];

    $errors = array();

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'O e-mail digitado é inválido.';
    } else {
      $user = get_user_by('email', $value);
      if ($user !== false) {
        $errors['email'] = 'Este e-mail já está cadastrado.';
      }
    }

    // TODO: validate location

    if (count($errors) > 0) {
      $this->_response(400, $errors);
    }

    // WordPress user_login does not accept +, but it does accept space
    $login = preg_replace('/[+]/', ' ', $email);

    $password = wp_generate_password();

    $user_id = wp_insert_user(Array(
      'user_login' => $login,
      'user_pass' => $password,
      'user_email' => $email,
      'display_name' => $email,
      'role' => 'None'
    ));

    if (is_wp_error($user_id)) {
      $this->_error($user_id->get_error_message());
    }

    if (!dolores_update_user_meta($user_id, 'location', $location)) {
      $this->_error('Não foi possível cadastrar sua localização.');
    }

    $user = get_user_by('id', $user_id);
    wp_set_current_user($user_id, $user->user_login);
    wp_set_auth_cookie($user_id);
    do_action('wp_login', $user->user_login);

    if (!is_user_logged_in()) {
      $this->_error('Não foi possível efetuar login.');
    }

    return Array();
  }
};
