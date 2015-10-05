<?php
require_once(__DIR__ . '/auth_cache.php');
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
    $auth_cache = new DoloresAuthCache();
    $data = $auth_cache->get($auth);
    if ($data) {
      return $data;
    }

    if ($auth['type'] == 'facebook') {
      $service = new DoloresFacebook();
    } else if ($auth['type'] == 'google') {
      $service = new DoloresGoogle();
    } else {
      return array('error' => 'Tipo de autenticação não suportado.');
    }

    $data = $service->authenticate($auth['code']);
    if (!array_key_exists('error', $data)) {
      $auth_cache->store($auth, $data);
    }
    return $data;
  }

  public static function signin($user) {
    wp_set_current_user($user->ID, $user->user_login);
    wp_set_auth_cookie($user->ID);
    do_action('wp_login', $user->user_login);
  }

  public static function signup($data) {
    $login = DoloresUsers::generate_login($data['name']);
    $picture = DoloresUsers::upload_profile_picture($data['picture']);

    if (is_array($picture) && array_key_exists('error', $picture)) {
      return $picture;
    }

    $password = wp_generate_password();

    $user_id = wp_insert_user(Array(
      'user_login' => $login,
      'user_nicename' => $login,
      'user_pass' => $password,
      'user_email' => $data['email'],
      'display_name' => $data['name'],
      'nickname' => $data['name'],
      'role' => 'None'
    ));

    if (is_wp_error($user_id)) {
      return array('error' => $user_id->get_error_message());
    }

    if (defined('MAILCHIMP_API_KEY') && defined('MAILCHIMP_LIST_ID')) {
      require_once(__DIR__ . '/external/mailchimp.php');
      $MailChimp = new DoloresMailChimp(MAILCHIMP_API_KEY);
      $MailChimp->fireAndForget('lists/subscribe', Array(
        'id' => MAILCHIMP_LIST_ID,
        'email' => array('email' => $email),
        'merge_vars' => array(
          'NOME' => $name,
          'CELULAR' => $phone,
          'BAIRRO' => $location,
          'ORIGEM' => 'Site'
        ),
        'double_optin' => false
      ));
    }

    $auth_key = 'auth_' . $data['auth']['type'];
    $auth_val = $data['auth']['id'];
    if (!dolores_update_user_meta($user_id, $auth_key, $auth_val)) {
      wp_delete_user($user_id);
      return array('error' => 'Não foi possível realizar o cadastro.');
    }

    if (!dolores_update_user_meta($user_id, 'picture', $picture)) {
      wp_delete_user($user_id);
      return array('error' => 'Não foi possível cadastrar sua imagem.');
    }

    if (!dolores_update_user_meta($user_id, 'location', $location)) {
      wp_delete_user($user_id);
      return array('error' => 'Não foi possível cadastrar sua localização.');
    }

    if (!dolores_update_user_meta($user_id, 'phone', $phone)) {
      wp_delete_user($user_id);
      return array('error' => 'Não foi possível cadastrar seu telefone.');
    }

    return get_user_by('id', $user_id);
  }

  public static function generate_login($name) {
    $slug = trim($name);
    $slug = strtolower($slug);
    $slug = preg_replace('/[[:blank:]]+/', '-', $slug);
    $slug = sanitize_user($slug, true);
    $test = $slug;
    for ($count = 1; ; $count++) {
      if (get_user_by('slug', $test) === false) {
        return $test;
      }
      $test = "$slug-$count";
    }
  }

  public static function upload_profile_picture($url) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');

    $temp_file = download_url($url, 5);

    $parts = explode('.', $url);
    $extension = $parts[count($parts)-1];

    if (is_wp_error($temp_file)) {
      return array('error' => 'Erro ao cadastrar imagem de perfil.');
    }

    $file = array(
      'name' => basename(preg_replace('/\?.*/', '', $url)),
      'type' => ($extension == 'png' ? 'image/png' : 'image/jpeg'),
      'tmp_name' => $temp_file,
      'error' => 0,
      'size' => filesize($temp_file)
    );

    $overrides = array(
      'test_form' => false,
      'test_size' => true,
      'test_upload' => true
    );

    $results = wp_handle_sideload($file, $overrides);

    if (!empty($results['error'])) {
      return array('error' => 'Erro ao cadastrar imagem de perfil.');
    }

    return $results['url'];
  }
};
