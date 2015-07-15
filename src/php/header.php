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
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script async src="<?php echo get_template_directory_uri(); ?>/script.js"></script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header>
  <h1>dolores</h1>
  <!-- TODO: menu -->
</header>
