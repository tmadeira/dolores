<?php
require_once(__DIR__ . '/dlib/assets.php');
?>
<footer class="site-footer">
  <div class="wrap">
    <ul class="footer-list">
      <!-- TODO: add social icons -->
    </ul>
    <ul class="footer-list footer-supporters">
      <?php
      $img_flc = DoloresAssets::get_image_uri('logo-flc.png');
      $img_psol = DoloresAssets::get_image_uri('logo-psol-carioca.png');
      ?>
      <li>
        <a href="http://laurocampos.org.br/" title="Fundação Lauro Campos">
          <img
            alt="Fundação Lauro Campos"
            class="footer-supporter-banner"
            src="<?php echo $img_flc; ?>"
            />
        </a>
      </li>
      <li>
        <a href="https://facebook.com/psolcarioca/" title="PSOL Carioca">
          <img
            alt="PSOL Carioca"
            class="footer-supporter-banner"
            src="<?php echo $img_psol; ?>"
            />
        </a>
      </li>
    </ul>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
