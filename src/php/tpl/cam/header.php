<?php
require_once(DOLORES_PATH . '/dlib/assets.php');
require_once(DOLORES_PATH . '/dlib/users.php');

$logo_img = DoloresAssets::get_image_uri('cam/logo-header.png');
?>
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
<?php
if (defined('GOOGLE_CLIENT_ID')) {
  echo '<meta name="google-signin-client_id"' .
       ' content="' . GOOGLE_CLIENT_ID . '" />';
}
?>
<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
DoloresAssets::print_style();
DoloresAssets::print_script();
wp_head();
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

    <nav class="header-nav">
      <?php
      wp_nav_menu(Array(
        'theme_location' => 'header-menu',
        'container' => 'div',
        'container_class' => 'header-menu'
      ));
      ?>

      <ul class="header-search-user">
        <li class="header-search">
          <form class="header-search-form" method="get" action="/">
            <i class="fa fa-search"></i>
            <input
              class="header-search-input"
              type="text"
              name="s"
              placeholder="Buscar"
              value="<?php if (array_key_exists('s', $_GET)) echo $_GET['s']; ?>"
              />
          </form>
        </li>
        <?php
        echo DoloresUsers::getUserHeaderLi();
        ?>
      </ul>
    </nav>

    <div class="header-toggle-menu"></div>
  </div>
  <div class="header-overlay"></div>
</header>
