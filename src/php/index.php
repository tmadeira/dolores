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
    <p>E se a cidade fosse nossa? Essa é a pergunta que nos une em movimento. Sonhamos com um Rio de Janeiro mais livre, solidário e feliz. Uma cidade que ouça as vozes das ruas para construir um novo modelo de governo com e para as pessoas.</p>
    <p>Queremos um Rio de Janeiro de direitos, onde as pessoas possam fazer parte das decisões que transformam as suas vidas.</p>
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
