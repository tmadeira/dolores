<?php
require_once(DOLORES_PATH . '/dlib/assets.php');
require_once(DOLORES_PATH . '/dlib/calendar.php');

$logo_src = DoloresAssets::get_image_uri('cam/logo-hero.png');

get_header();

if (!$paged || $paged == 1) {
  ?>
  <section class="site-presentation explanation">
    <div class="wrap explanation-wrap">
      <p style="font-size: 36px; text-align: center; padding: 10px;">
        Aqui vai o vídeo de apresentação
        <!-- TODO -->
      </p>
    </div>
  </section>

  <section class="site-hero">
    <div class="hero-credit">
      Foto: Ivo Gonçalves/PMPA
    </div>
    <div class="hero-logo-container">
      <a href="<?php echo site_url(); ?>" title="Página inicial">
        <img class="hero-logo-image" src="<?php echo $logo_src; ?>" />
      </a>
    </div>
    <button class="hero-button toggle-explanation">
      <span>Entenda</span>
    </button>
    <?php
    require(DOLORES_TEMPLATE_PATH . '/home-calendar.php');
    ?>
  </section>

  <section class="home-temas">
    <div class="wrap home-temas-wrap">
      <div class="home-temas-element">
        <h2 class="home-temas-title">Entre no debate</h2>

        <?php
        require(DOLORES_TEMPLATE_PATH . '/temas-grid.php');
        ?>

        <div class="home-temas-button-container">
          <a class="home-temas-button" href="/temas/">
            Veja todos os temas
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="home-bairros">
    <div class="wrap">
      <?php require(DOLORES_TEMPLATE_PATH . '/bairros-map.php'); ?>
    </div>
  </section>

  <section class="home-banners">
    <div class="wrap">
      <a class="home-banner home-voluntario" href="/seja-um-voluntario/"
          title="Seja um voluntário">
        <span>Seja um voluntário</span>
      </a>
      <a class="home-banner home-contribuicoes" href="/c/contribuicoes/"
          title="Contribuições para o debate">
        <span>Contribuições para o debate</span>
      </a>
    </div>
  </section>

  <hr class="home-sep" />

  <?php
}

dolores_grid();

get_footer();
