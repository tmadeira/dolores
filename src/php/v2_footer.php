<?php
require_once(__DIR__ . '/dlib/assets.php');

$logo = DoloresAssets::get_image_uri('v2-logo.png');

$img_flc = DoloresAssets::get_image_uri('logo-flc.png');
$img_psol = DoloresAssets::get_image_uri('logo-psol-carioca.png');
?>
<footer class="site-footer">
  <div class="wrap">
    <div class="footer-logo">
      <a href="<?php echo site_url(); ?>" title="Página inicial">
        <img src="<?php echo $logo; ?>" />
      </a>
    </div>

    <?php
    wp_nav_menu(Array(
      'theme_location' => 'footer-menu',
      'container' => 'nav',
      'container_class' => 'footer-menu'
    ));
    ?>

    <div class="footer-note">
      <p>
        <a href="http://laurocampos.org.br/" target="_blank"
            title="Fundação Lauro Campos">
          <img alt="Fundação Lauro Campos" class="footer-supporter-banner"
              src="<?php echo $img_flc; ?>" />
        </a>
        &nbsp; &nbsp;
        <a href="https://facebook.com/psolcarioca/" target="_blank"
            title="PSOL Carioca">
          <img alt="PSOL Carioca" class="footer-supporter-banner"
              src="<?php echo $img_psol; ?>" />
        </a>
      </p>

      <p>
        Copyleft &copy; <?php echo date("Y"); ?><br />
        <?php bloginfo('name'); ?>
      </p>

      <p>
        O conteúdo deste site, exceto quando proveniente de outras fontes ou
        onde especificado o contrário, está licenciado sob a Creative Commons
        by-sa 3.0 BR.
      </p>
    </div>
  </div>
</footer>

<div id="authenticator"></div>

<?php wp_footer(); ?>
</body>
</html>
