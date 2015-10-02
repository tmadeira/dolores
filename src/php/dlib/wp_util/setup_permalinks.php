<?php
class DoloresPermalinks {
  public function __construct() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'perfil';
    add_action('after_switch_theme', Array($this, 'flush_rules'));
    // Uncomment the line below to force flush
    //add_action('wp_loaded', Array($this, 'flush_rules'));
  }

  public function flush_rules() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules(false);
  }
};

new DoloresPermalinks();
