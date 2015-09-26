<?php
require_once(__DIR__ . '/dlib/assets.php');

$icn_facebook = DoloresAssets::get_image_uri('social-facebook.svg');
$icn_email = DoloresAssets::get_image_uri('social-email.svg');
$icn_youtube = DoloresAssets::get_image_uri('social-youtube.svg');

$img_flc = DoloresAssets::get_image_uri('logo-flc.png');
$img_psol = DoloresAssets::get_image_uri('logo-psol-carioca.png');
?>
<footer class="site-footer">
  <div class="wrap">
    <ul class="footer-list">
      <li>
        <a href="http://facebook.com/seacidadefossenossa" target="_blank"
            title="Facebook">
          <img alt="Facebook" class="footer-social-icon"
              src="<?php echo $icn_facebook; ?>" />
        </a>
      </li>
      <li>
        <a href="mailto:seacidadefossenossa@gmail.com" target="_blank"
            title="E-mail">
          <img alt="E-mail" class="footer-social-icon"
              src="<?php echo $icn_email; ?>" />
        </a>
      </li>
      <li>
        <a href="https://www.youtube.com/channel/UCJScw9XfBIDUIlTZ8u1WyhQ"
            target="_blank" title="YouTube">
          <img alt="YouTube" class="footer-social-icon"
              src="<?php echo $icn_youtube; ?>" />
        </a>
      </li>
    </ul>
    <ul class="footer-list footer-supporters">
      <li>
        <a href="http://laurocampos.org.br/" target="_blank"
            title="Fundação Lauro Campos">
          <img alt="Fundação Lauro Campos" class="footer-supporter-banner"
              src="<?php echo $img_flc; ?>" />
        </a>
      </li>
      <li>
        <a href="https://facebook.com/psolcarioca/" target="_blank"
            title="PSOL Carioca">
          <img alt="PSOL Carioca" class="footer-supporter-banner"
              src="<?php echo $img_psol; ?>" />
        </a>
      </li>
    </ul>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
