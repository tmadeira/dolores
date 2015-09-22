<?php
function dolores_register_post_types() {
  $post_args = array(
    'label' => 'Ideia',
    'labels' => array(
      'name' => 'Ideias',
      'singular_name' => 'Ideia',
      'add_new' => 'Adicionar Nova',
      'add_new_item' => 'Adicionar nova ideia',
      'edit_item' => 'Editar ideia',
      'menu_name' => 'Ideias',
      'new_item' => 'Nova ideia',
      'not_found' => 'Nenhuma ideia encontrada',
      'not_found_in_trash' => 'Nenhuma ideia encontrada na lixeira',
      'search_items' => 'Procurar ideias',
      'view_item' => 'Visualizar ideia'
    ),
    'description' => 'Ideia proposta por usuário da plataforma',
    'has_archive' => true,
    'menu_icon' => 'dashicons-lightbulb',
    'menu_position' => 5, /* Below posts */
    'public' => true,
    'show_in_menu' => true,
    'supports' => array('title', 'editor', 'author', 'comments', 'revisions')
  );

  $cat_args = array(
    'label' => 'Temas',
    'labels' => array(
      'name' => 'Temas',
      'singular_name' => 'Tema',
      'add_new' => 'Adicionar Novo',
      'add_new_item' => 'Adicionar novo tema',
      'edit_item' => 'Editar tema',
      'menu_name' => 'Temas',
      'new_item' => 'Novo tema',
      'not_found' => 'Nenhum tema encontrado',
      'not_found_in_trash' => 'Nenhum tema encontrado na lixeira',
      'search_items' => 'Procurar temas',
      'view_item' => 'Visualizar tema'
    ),
    'hierarchical' => true,
    'public' => true
  );

  register_post_type('ideia', $post_args);
  register_taxonomy('tema', array('ideia'), $cat_args);
}

add_action('init', 'dolores_register_post_types');
