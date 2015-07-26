<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');
require_once(__DIR__ . '/../wp_util/user_meta.php');

class DoloresSignupAPI extends DoloresBaseAPI {
  function post($request) {
    $email = $request['email'];
    $location = $request['location'];

    // TODO: validate email
    // TODO: validate location

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
      // TODO: Return error in some sanitized format
      $this->_error($user_id);
    }

    if (!dolores_update_user_meta($user_id, 'location', $location)) {
      $this->_error('Unable to update location.');
    }

    $user = get_user_by('id', $user_id);
    wp_set_current_user($user_id, $user->user_login);
    wp_set_auth_cookie($user_id);
    do_action('wp_login', $user->user_login);

    if (!is_user_logged_in()) {
      $this->_error('Unable to log in.');
    }

    return Array();
  }
};
