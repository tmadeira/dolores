<?php
$ideia_label = 'Ideia';
$ideia_labels = array(
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
);

// TODO: Move this to template configuration
if (DOLORES_TEMPLATE == 'cam') {
  $ideia_label = 'Proposta';
  $ideia_labels = array(
    'name' => 'Propostas',
    'singular_name' => 'Proposta',
    'add_new' => 'Adicionar Nova',
    'add_new_item' => 'Adicionar nova proposta',
    'edit_item' => 'Editar proposta',
    'menu_name' => 'Propostas',
    'new_item' => 'Nova proposta',
    'not_found' => 'Nenhuma proposta encontrada',
    'not_found_in_trash' => 'Nenhuma proposta encontrada na lixeira',
    'search_items' => 'Procurar propostas',
    'view_item' => 'Visualizar proposta'
  );
}

function dolores_register_post_types() {
  global $ideia_label, $ideia_labels;
  $post_args = array(
    'label' => $ideia_label,
    'labels' => $ideia_labels,
    'description' => 'Proposta feita por usuário da plataforma',
    'has_archive' => true,
    'menu_icon' => 'dashicons-lightbulb',
    'menu_position' => 5, /* Below posts */
    'public' => true,
    'show_in_menu' => true,
    'supports' => array(
      'title',
      'editor',
      'author',
      'comments',
      'revisions',
      'thumbnail'
    ),
    'yarpp_support' => true
  );

  $tema_args = array(
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
    'public' => true,
    'rewrite' => array(
      'hierarchical' => true
    )
  );

  $local_args = array(
    'label' => 'Locais',
    'labels' => array(
      'name' => 'Locais',
      'singular_name' => 'Local',
      'add_new' => 'Adicionar Novo',
      'add_new_item' => 'Adicionar novo local',
      'edit_item' => 'Editar local',
      'menu_name' => 'Locais',
      'new_item' => 'Novo local',
      'not_found' => 'Nenhum local encontrado',
      'not_found_in_trash' => 'Nenhum local encontrado na lixeira',
      'search_items' => 'Procurar locais',
      'view_item' => 'Visualizar local'
    ),
    'hierarchical' => true,
    'public' => true,
    'rewrite' => array(
      'hierarchical' => true
    )
  );

  register_post_type('ideia', $post_args);
  register_taxonomy('tema', array('ideia'), $tema_args);
  register_taxonomy('local', array('ideia'), $local_args);
}

add_action('init', 'dolores_register_post_types');
