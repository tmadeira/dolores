<?php
function dolores_dequeue_yarpp_header_styles() {
  wp_dequeue_style('yarppWidgetCss');
}

function dolores_dequeue_yarpp_footer_styles() {
  wp_dequeue_style('yarppRelatedCss');
}

add_action('wp_print_styles', 'dolores_dequeue_yarpp_header_styles');
add_action('get_footer', 'dolores_dequeue_yarpp_footer_styles');
