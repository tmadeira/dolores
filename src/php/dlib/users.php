<?php
require_once(DOLORES_PATH . '/dlib/assets.php');
require_once(DOLORES_PATH . '/dlib/auth_cache.php');
require_once(DOLORES_PATH . '/dlib/locations.php');
require_once(DOLORES_PATH . '/dlib/mailer.php');
require_once(DOLORES_PATH . '/dlib/external/facebook.php');
require_once(DOLORES_PATH . '/dlib/external/google.php');
require_once(DOLORES_PATH . '/dlib/wp_util/user_meta.php');

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

  public static function authenticate($auth, $use_cache = false) {
    $auth_cache = new DoloresAuthCache();

    if ($use_cache) {
      if ($data = $auth_cache->get($auth)) {
        return $data;
      }
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

    if ($data['picture']) {
      $picture = DoloresUsers::upload_profile_picture($data['picture']);

      if (is_array($picture) && array_key_exists('error', $picture)) {
        return $picture;
      }
    }

    $password = wp_generate_password();

    $user_id = wp_insert_user(Array(
      'user_login' => $login,
      'user_nicename' => $login,
      'user_pass' => $password,
      'user_email' => $data['email'],
      'display_name' => $data['name'],
      'nickname' => $data['name'],
      'role' => get_option('default_role')
    ));

    if (is_wp_error($user_id)) {
      return array('error' => $user_id->get_error_message());
    }

    DoloresMailer::subscribe(array(
      'type' => 'user',
      'email' => $data['email'],
      'name' => $data['name'],
      'phone' => $data['phone'],
      'bairro' => $data['location']
    ));

    $auth_key = 'auth_' . $data['auth']['type'];
    $auth_val = $data['auth']['id'];
    if (!dolores_update_user_meta($user_id, $auth_key, $auth_val)) {
      wp_delete_user($user_id);
      return array('error' => 'Não foi possível realizar o cadastro.');
    }

    if ($picture && !dolores_update_user_meta($user_id, 'picture', $picture)) {
      wp_delete_user($user_id);
      return array('error' => 'Não foi possível cadastrar sua imagem.');
    }

    if (!dolores_update_user_meta($user_id, 'location', $data['location'])) {
      wp_delete_user($user_id);
      return array('error' => 'Não foi possível cadastrar sua localização.');
    }

    if (!dolores_update_user_meta($user_id, 'phone', $data['phone'])) {
      wp_delete_user($user_id);
      return array('error' => 'Não foi possível cadastrar seu telefone.');
    }

    DoloresLocations::get_instance()->get_missing($data['location']);
    DoloresUsers::send_welcome_email($user_id);

    return get_user_by('id', $user_id);
  }

  public static function send_welcome_email($user_id) {
    $user = get_user_by('id', $user_id);
    $args = array('NAME' => $user->display_name);
    return dolores_mail($user->user_email, 'welcome_email.html', $args);
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

  public static function getUserHeaderLi() {
    if (is_user_logged_in()) {
      $user = wp_get_current_user();
      $picture = dolores_get_profile_picture($user);
      $style = ' style="background-image: url(\'' . $picture. '\');"';

      $logout = wp_logout_url(site_url());
      $profile = get_author_posts_url($user->ID);
      $edit = "javascript:DoloresAuthenticator.editUserInfo();void(0);";

      $display_name = esc_attr($user->display_name);

      $html = <<<HTML
<li class="user-logged menu-item-has-children">
  <a
      href="{$profile}"
      title="{$display_name}"
      >
    <span class="user-logged-picture"{$style}></span>
    <span class="user-logged-name">
      {$user->display_name}
    </span>
  </a>
  <div class="sub-menu user-logged-menu">
    <div class="user-logged-menu-picture"{$style}></div>
    <div class="user-logged-menu-info">
      <h3 class="user-logged-menu-name">
        {$user->display_name}
      </h3>
      <ul class="user-logged-menu-ul">
        <li><a href="{$profile}">Ver perfil</a></li>
        <li><a href="{$edit}">Editar perfil</a></li>
        <li><a href="{$logout}">Sair</a></li>
      </ul>
    </div>
  </div>
</li>
HTML;
    } else {
      $signin = "Entrar";
      if (DOLORES_TEMPLATE == 'cam') {
        $signin = "Participe";
      }
      $html = <<<HTML
<li class="user-signin">
  <a href="javascript:DoloresAuthenticator.signIn();void(0)">
    <i class="fa fa-user"></i> $signin
  </a>
</li>
HTML;
    }

    return $html;
  }
};
