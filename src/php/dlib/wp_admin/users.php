<?php
function dolores_manage_users_columns($columns) {
  $columns['location'] = 'Localização';
  return $columns;
}

function dolores_manage_users_custom_column($val, $column_name, $user_id) {
  $value = get_user_meta($user_id, $column_name, true);
  return $value;
}

add_filter('manage_users_columns', 'dolores_manage_users_columns');
add_filter('manage_users_custom_column', 'dolores_manage_users_custom_column', 10, 3);
