<?php
function dolores_update_user_meta($user_id, $key, $value) {
  update_user_meta($user_id, $key, $value);
  return get_user_meta($user_id, $key, true) == $value;
}

function dolores_get_profile_picture($user) {
  $picture = get_user_meta($user->ID, 'picture', true);
  if (!$picture) {
    $hash = md5(strtolower(trim($user->user_email)));
    $picture = "http://gravatar.com/avatar/$hash?d=mm&s=300";
  }
  return $picture;
}
