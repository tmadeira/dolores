<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" <?php
  language_attributes();
?>>

<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="theme-color" content="#000000" />
<meta name="mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
  require_once(__DIR__ . '/dlib/assets.php');
  DoloresAssets::print_style();
  DoloresAssets::print_script();
  wp_head();
  $logo_img = DoloresAssets::get_image_uri('logo-se-a-cidade-fosse-nossa.png');
?>
</head>

<body <?php body_class(); ?>>
<header class="site-header">
  <div class="wrap">
    <h1 class="header-logo">
      <a href="<?php echo site_url(); ?>" title="Página inicial">
        <img src="<?php echo $logo_img; ?>" alt="<?php bloginfo('name'); ?>" />
      </a>
    </h1>

    <?php
    wp_nav_menu(Array(
      'theme_location' => 'header-menu',
      'container' => 'nav',
      'container_class' => 'header-menu'
    ));
    ?>

    <div class="header-toggle-menu"></div>
  </div>
  <div class="header-overlay"></div>
</header>
