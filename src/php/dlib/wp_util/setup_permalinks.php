<?php
class DoloresPermalinks {
  public static function flush_rules() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'perfil';
    $wp_rewrite->flush_rules(false);
  }
};

add_action('after_switch_theme', Array('DoloresPermalinks', 'flush_rules'));

/**
 * Uncomment the line below to force flush
 */
//add_action('wp_loaded', Array('DoloresPermalinks', 'flush_rules'));
