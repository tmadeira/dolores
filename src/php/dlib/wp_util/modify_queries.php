<?php
function dolores_pre_get_posts($query) {
  if ($query->is_author && $query->is_main_query()) {
    $query->query_vars['post_type'] = 'ideia';
  }

  if ($query->is_author || $query->is_tax) {
    $query->set('posts_per_page', 9);
  }
}

add_action('pre_get_posts', 'dolores_pre_get_posts');
