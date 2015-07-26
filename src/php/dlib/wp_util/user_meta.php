<?php
function dolores_update_user_meta($user_id, $key, $value) {
  update_user_meta($user_id, $key, $value);
  return get_user_meta($user_id, $key, true) == $value;
}
