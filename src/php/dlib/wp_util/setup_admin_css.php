<?php
function dolores_admin_css() {
  $css = DoloresAssets::get_theme_uri('shared/admin.css');
  ?>
  <link rel="stylesheet" href="<?php echo $css; ?>" type="text/css" media="all" />
  <?php
}

add_action('admin_head', 'dolores_admin_css');
