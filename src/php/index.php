<?php
require_once(__DIR__ . '/dlib/assets.php');
require_once(__DIR__ . '/dlib/wp_util/add_paged_class.php');
require_once(__DIR__ . '/dlib/settings/streaming.php');

get_header();

$hero_src = DoloresAssets::get_image_uri('hero-image.jpg');

if (!$paged || $paged == 1) {
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

  <?php
  if (DoloresStreaming::get_active()) {
    $title = esc_html(DoloresStreaming::get_title());
    $youtube_id = DoloresStreaming::get_youtube_id();
    $params = "rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1";
    $url = "//youtube.com/embed/${youtube_id}?${params}";
    ?>
    <section class="site-streaming">
      <div class="wrap">
        <h2 class="streaming-title"><?php echo $title; ?></h2>
        <iframe
          class="streaming-box"
          src="<?php echo $url; ?>"
          frameborder="0"
          allowfullscreen>
        </iframe>
      </div>
    </section>
    <?php
  }
}

include(__DIR__ . '/grid.php');
?>

<?php
get_footer();
?>
