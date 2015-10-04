<?php
require_once(__DIR__ . '/external/facebook.php');
require_once(__DIR__ . '/external/google.php');

class DoloresUsers {
  public static function getUserByUniqueField($field, $value) {
    $users = get_users(array(
      'meta_key' => $field,
      'meta_value' => $value,
      'fields' => array('ID', 'user_login')
    ));

    if (count($users) === 1) {
      return $users[0];
    }

    return null;
  }

  public static function authenticate($auth) {
    if ($auth['type'] == 'facebook') {
      $fb = new DoloresFacebook();
      return $fb->authenticate($auth['token']);
    } else if ($auth['type'] == 'google') {
      $google = new DoloresGoogle();
      return $google->authenticate($auth['code']);
    }

    return array('error' => 'Tipo de autenticação não suportado.');
  }

  public static function signin($user) {
    wp_set_current_user($user->ID, $user->user_login);
    wp_set_auth_cookie($user->ID);
    do_action('wp_login', $user->user_login);
  }
};
