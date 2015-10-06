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
  require_once(__DIR__ . '/dlib/assets.php');
  DoloresAssets::print_style();
  DoloresAssets::print_script();
  wp_head();
  $logo_img = DoloresAssets::get_image_uri('logo-se-a-cidade-fosse-nossa.png');
?>
</head>

<body <?php body_class("v" . dolores_get_version()); ?>>
<header class="site-header">
  <div class="wrap">
    <h1 class="header-logo">
      <a href="<?php echo site_url(); ?>" title="Página inicial">
        <img src="<?php echo $logo_img; ?>" alt="<?php bloginfo('name'); ?>" />
      </a>
    </h1>

    <nav class="header-nav">
      <?php
      if (dolores_get_version() > 1) {
        wp_nav_menu(Array(
          'theme_location' => 'header-menu',
          'container' => 'div',
          'container_class' => 'header-menu'
        ));
      } else {
        ?>
        <div class="header-menu"><ul id="menu-cabecalho" class="menu"><li id="menu-item-33" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-33"><a href="/">Página inicial</a></li>
<li id="menu-item-31" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31"><a href="http://seacidadefossenossa.com.br/sobre/">Sobre</a></li>
<li id="menu-item-29" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-29"><a href="http://seacidadefossenossa.com.br/calendario/">Calendário</a></li>
<li id="menu-item-34" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-34"><a href="http://seacidadefossenossa.com.br/secoes/propostas/">Propostas</a></li>
<li id="menu-item-82" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-82"><a href="http://seacidadefossenossa.com.br/secoes/apoio/">Apoios</a></li>
</ul></div>
        <?php
      }
      ?>

      <?php if (dolores_get_version() > 1) { ?>
      <ul class="header-search-user">
        <li class="header-search">
          <form class="header-search-form" method="get" action="/">
            <i class="fa fa-search"></i>
            <input
              class="header-search-input"
              type="text"
              name="s"
              placeholder="Buscar"
              />
          </form>
        </li>
        <?php
        if (is_user_logged_in()) {
          $user = wp_get_current_user();
          require_once(__DIR__ . '/dlib/wp_util/user_meta.php');
          $picture = dolores_get_profile_picture($user);
          $style = ' style="background-image: url(\'' . $picture. '\');"';

          $cur_url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
          $logout_link = wp_logout_url($cur_url);
          ?>
          <li class="user-logged">
            <a
                href="<?php echo $logout_link; ?>"
                title="<?php echo esc_attr($user->display_name); ?>"
                >
              <span class="user-logged-picture"<?php echo $style; ?>></span>
            </a>
          </li>
          <?php
        } else {
          ?>
          <li class="user-signin">
            <a href="javascript:DoloresAuthenticator.signIn();void(0)">
              <i class="fa fa-user"></i> Entrar
            </a>
          </li>
          <?php
          }
        ?>
      </ul>
      <?php } ?>
    </nav>

    <div class="header-toggle-menu"></div>
  </div>
  <div class="header-overlay"></div>
</header>
