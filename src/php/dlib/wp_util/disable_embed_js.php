<?php
function dolores_disable_embed_js($args) {
  wp_dequeue_script('wp-embed');
}

add_action('wp_footer', 'dolores_disable_embed_js');
