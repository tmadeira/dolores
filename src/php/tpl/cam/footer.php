<?php
require_once(DOLORES_PATH . '/dlib/assets.php');

$logo = DoloresAssets::get_image_uri('cam/logo-footer.png');

$img_flc = DoloresAssets::get_image_uri('shared/logo-flc.png');
$img_psol = DoloresAssets::get_image_uri('cam/logo-psol-rs.png');
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
      <h3 class="footer-title">Apoio</h3>

      <p>
        <a href="http://laurocampos.org.br/" target="_blank"
            title="Fundação Lauro Campos">
          <img alt="Fundação Lauro Campos" class="footer-supporter-banner"
              src="<?php echo $img_flc; ?>" />
        </a>
        &nbsp; &nbsp;
        <img alt="PSOL RS" class="footer-supporter-banner"
            src="<?php echo $img_psol; ?>" />
      </p>

      <p>
        &copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?><br />
        Conteúdo sob
        <a
            href="http://creativecommons.org/licenses/by-sa/3.0/br/"
            target="_blank"
            >
          licença Creative Commons (by-sa 3.0 BR)
        </a>
      </p>

      <p>
        <i class="fa fa-wordpress"></i>
        Esta plataforma é livre e roda sobre WordPress.<br />
        <a href="https://github.com/tmadeira/dolores" target="_blank">
          <i class="fa fa-github"></i> Código-fonte no GitHub
        </a>
      </p>
    </div>
  </div>
</footer>

<div id="authenticator"></div>

<?php wp_footer(); ?>
</body>
</html>
