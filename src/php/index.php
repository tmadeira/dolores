<?php
get_header();

require_once(__DIR__ . '/dlib/assets.php');

$hero_src = DoloresAssets::get_image_uri('hero-image.jpg');
?>

<section class="site-hero"
    style="background-image: url('<?php echo $hero_src; ?>');">
  <div id="react-hero-signup">
  </div>
</section>

<section class="site-presentation">
  <div class="wrap">
    <h3 class="presentation-title">Lorem ipsum dolor sit amet</h3>
    <p class="presentation-text">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua.
    </p>
  </div>
</section>

<?php /*
<section class="site-streaming">
  <div class="wrap">
    <iframe
        class="streaming-box"
        src="//youtube.com/embed/zE_I18HfeWM?controls=0&amp;showinfo=0"
        frameborder="0"
        allowfullscreen>
    </iframe>
  </div>
</section>
*/ ?>

<?php
include(__DIR__ . '/grid.php');
?>

<?php
get_footer();
?>
