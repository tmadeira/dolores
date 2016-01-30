<?php
require_once(DOLORES_PATH . '/dlib/wp_admin/settings/home.php');
require_once(DOLORES_PATH . '/dlib/wp_admin/settings/streaming.php');
require_once(DOLORES_PATH . '/dlib/wp_admin/settings/opengraph.php');

class DoloresSettings {
  public function __construct() {
    add_action('admin_menu', array($this, 'add_page'));
    add_action('admin_init', array('DoloresHome', 'admin_init'));
    add_action('admin_init', array('DoloresStreaming', 'admin_init'));
    add_action('admin_init', array('DoloresOGSettings', 'admin_init'));
  }

  public function add_page() {
    add_dashboard_page(
      'Configurações do Dolores',
      'Dolores',
      'edit_themes',
      'dolores_settings',
      array($this, 'create_admin_page')
    );
  }

  public function create_admin_page() {
    ?>
    <div class="wrap">
      <h2>Configurações do Dolores</h2>
      <form method="post" action="options.php">
        <?php
        settings_fields('dolores');
        do_settings_sections('dolores');
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }
}

if (is_admin()) {
  new DoloresSettings();
}
