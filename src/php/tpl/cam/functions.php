<?php
session_start();

add_image_size('grid-thumbnail', 350, 230, true);
add_image_size('home-destaques', 80, 80, true);
require_once(DOLORES_TEMPLATE_PATH . '/grid.php');
require_once(DOLORES_TEMPLATE_PATH . '/grid-ideias.php');

define('CALENDAR_ID', '4spn2cn6gpde1jf0mpdu34ti7s@group.calendar.google.com');

function dolores_remove_profile() {
	remove_menu_page('profile.php');
	remove_submenu_page('users.php', 'profile.php');
	if (IS_PROFILE_PAGE === true) {
		wp_die('Sem permissões suficientes.');
	}
}
add_action('admin_menu', 'dolores_remove_profile');

function dolores_random_orderby() {
  return "RAND()";
}
