<?php
function dolores_register_menus() {
  register_nav_menus(Array(
    'header-menu' => 'Menu do cabeçalho',
    'footer-menu' => 'Menu do rodapé'
  ));
}

add_action('init', 'dolores_register_menus');
