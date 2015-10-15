<?php
function dolores_pre_get_posts($query) {
  if (is_home() && !$query->query_vars['category_name']) {
    $cats = array(
      get_cat_ID('Ações'),
      get_cat_ID('Apoios'),
      get_cat_ID('Diagnósticos')
    );
    $query->query_vars['category__not_in'] = $cats;
  }

  if ($query->is_author && $query->is_main_query()) {
    $query->query_vars['post_type'] = 'ideia';
  }

  if ($query->is_author || $query->is_tax) {
    $query->set('posts_per_page', 9);
  }
}

add_action('pre_get_posts', 'dolores_pre_get_posts');
