<?php
require_once(__DIR__ . '/dlib/wp_util/disable_admin_bar.php');
require_once(__DIR__ . '/dlib/wp_util/disable_emojis.php');
require_once(__DIR__ . '/dlib/wp_util/modify_queries.php');
require_once(__DIR__ . '/dlib/wp_util/register_menus.php');
require_once(__DIR__ . '/dlib/wp_util/register_post_types.php');
require_once(__DIR__ . '/dlib/wp_util/setup_avatar.php');
require_once(__DIR__ . '/dlib/wp_util/setup_editor.php');
require_once(__DIR__ . '/dlib/wp_util/setup_opengraph.php');
require_once(__DIR__ . '/dlib/wp_util/setup_permalinks.php');
require_once(__DIR__ . '/dlib/wp_util/setup_thumbnails.php');

require_once(__DIR__ . '/dlib/wp_admin/settings.php');
require_once(__DIR__ . '/dlib/wp_admin/taxonomy.php');
require_once(__DIR__ . '/dlib/wp_admin/users.php');

function dolores_get_version() {
  if (array_key_exists('v', $_GET)) {
    return $_GET['v'];
  }

  if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $google = get_user_meta($user->ID, 'auth_google', true);
    $facebook = get_user_meta($user->ID, 'auth_facebook', true);
    if ($google || $facebook) {
      return 2;
    }
  }

  return 1;
}
