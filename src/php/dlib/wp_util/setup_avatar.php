<?php
require_once(DOLORES_PATH . '/dlib/wp_util/user_meta.php');

function dolores_get_avatar($avatar, $id_or_email, $size, $default, $alt) {
	$user = false;

	if (is_numeric($id_or_email)) {
		$id = (int) $id_or_email;
		$user = get_user_by('id' , $id);
	} else if (is_object($id_or_email)) {
		if (!empty($id_or_email->user_id)) {
			$id = (int) $id_or_email->user_id;
			$user = get_user_by('id', $id);
		}
	} else {
		$user = get_user_by('email', $id_or_email);
	}

	if ($user && is_object($user)) {
    $url = dolores_get_profile_picture($user);
    $avatar = "<img alt='{$alt}' src='{$url}' ";
    $avatar.= "  class='avatar avatar-{$size} photo' ";
    $avatar.= "  height='{$size}' width='{$size}' />";
	}

  return $avatar;
}

add_filter('get_avatar', 'dolores_get_avatar', 1, 5);
