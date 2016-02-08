<?php
require_once(DOLORES_PATH . '/dlib/assets.php');

$logo_src = DoloresAssets::get_image_uri('cam/logo-hero.png');

get_header();

if (!$paged || $paged == 1) {
  ?>
  <section class="site-presentation explanation">
    <div clsas="wrap explanation-wrap">
      <!-- TODO -->
    </div>
  </section>

  <section class="site-hero">
    <div class="hero-logo-container">
      <a href="<?php echo site_url(); ?>" title="Página inicial">
        <img class="hero-logo-image" src="<?php echo $logo_src; ?>" />
      </a>
    </div>
    <button class="hero-button toggle-explanation">
      <span>Entenda</span>
    </button>

    <div class="home-calendar">
      <div class="wrap">
        <h2 class="home-next-event">
          <span>Próximo evento</span>
        </h2><h3 class="home-event-title">
          Cine-debate com Samir de Oliveira sobre jornalismo socialista revolucionário
        </h3><ul class="home-event-info">
          <li class="home-event-info-li home-event-info-50">
            <i class="fa fa-fw fa-lg fa-calendar"></i>23/02
          </li><li class="home-event-info-li home-event-info-50">
            <i class="fa fa-fw fa-lg fa-clock-o"></i>14h
          </li><li class="home-event-info-li">
            <a class="home-event-location" href="#">
              <div class="home-event-icon-container">
                <i class="fa fa-fw fa-lg fa-map-marker"></i>
              </div>
              <div class="home-event-location-text">
                Sede do PSOL
                <br />
                <small>(ver no mapa)</small>
              </div>
            </a>
          </li>
        </ul><div class="home-calendar-button-container">
          <a class="home-calendar-button" href="#" title="Agenda completa">
            <?php
            $uri = DoloresAssets::get_image_uri('cam/home-calendar-full.png');
            ?>
            <img alt="Agenda completa" src="<?php echo $uri; ?>" />
          </a>
        </div>
      </div>
    </div>
  </section>

  <?php
  if (DoloresStreaming::get_active()) {
    $title = esc_html(DoloresStreaming::get_title());
    $youtube_id = DoloresStreaming::get_youtube_id();
    $params = "rel=0&amp;showinfo=0&amp;autoplay=1";
    $url = "//youtube.com/embed/${youtube_id}?${params}";
    ?>
    <section class="site-streaming">
      <div class="page wrap">
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
  ?>

  <!-- TODO -->

  <?php
}
?>

<?php get_footer(); ?>
