<?php
require_once(__DIR__ . '/dlib/assets.php');
require_once(__DIR__ . '/dlib/wp_util/add_paged_class.php');
require_once(__DIR__ . '/dlib/wp_admin/settings/home.php');
require_once(__DIR__ . '/dlib/wp_admin/settings/streaming.php');

get_header();

$hero_src = DoloresAssets::get_image_uri('v2-hero-image.jpg');
$logo_src = DoloresAssets::get_image_uri('v2-logo.png');

$video_mp4 = DoloresAssets::get_static_uri('videos/mare.mp4');
$video_webm = DoloresAssets::get_static_uri('videos/mare.webm');

if (!$paged || $paged == 1) {
  ?>
  <section class="site-presentation explanation">
    <div class="wrap explanation-wrap">
      <iframe
        width="853"
        height="480"
        src="https://www.youtube.com/embed/5Zbs3grhys0?rel=0&amp;controls=0&amp;showinfo=0"
        frameborder="0"
        allowfullscreen
        >
      </iframe>

      <button
          class="site-presentation-button"
          onclick="DoloresAuthenticator.signIn(null, function() { location.href = '/temas'; })"
          >
        Gostou? Clique aqui para participar!
      </button>
    </div>
  </section>

  <section class="site-hero"
      style="background-image: url('<?php echo $hero_src; ?>');">
    <video class="hero-video" autoplay="autoplay" loop="loop"
        poster="<?php echo $hero_src; ?>">
      <source src="<?php echo $video_mp4; ?>" type="video/mp4" />
      <source src="<?php echo $video_webm; ?>" type="video/webm" />
    </video>
    <div class="hero-logo-container">
      <a href="<?php echo site_url(); ?>" title="Página inicial">
        <img class="hero-logo-image" src="<?php echo $logo_src; ?>" />
      </a>
    </div>
    <button class="hero-button toggle-explanation">
      Entenda
    </button>
  </section>

  <?php
  if (DoloresStreaming::get_active()) {
    $title = esc_html(DoloresStreaming::get_title());
    $youtube_id = DoloresStreaming::get_youtube_id();
    $params = "rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1";
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

  <section class="home-default-section">
    <div class="wrap">
      <ul class="home-main-grid">
        <li class="home-main-item home-bg-map">
          <a href="#" class="home-main-item-link home-main-item-link-no-alpha">
            <div class="home-main-item-border"></div>
            <div class="home-main-item-wrap">
              <h3 class="home-main-item-title">
                Que mudanças você quer para o seu bairro?
              </h3>
              <button class="home-main-item-action">Participe</button>
            </div>
          </a>
        </li>

        <?php
        $taxonomy = 'tema';
        $slug = DoloresHome::get_tema();
        $term = get_term_by('slug', $slug, $taxonomy);
        $link = get_term_link($term, $taxonomy);
        $image = get_term_meta($term->term_id, 'image', true);
        ?>
        <li
            class="home-main-item"
            style="background-image: url('<?php echo $image; ?>');"
            >
            <a href="<?php echo $link; ?>" class="home-main-item-link">
            <div class="home-main-item-wrap">
              <h3 class="home-main-item-title">
                <?php echo $term->name; ?>
              </h3>
              <p class="home-main-item-explanation">
                E se as decisões fossem nossas?
              </p>
              <button class="home-main-item-action">Participe</button>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </section>

  <section class="home-ideas">
    <div class="wrap">
      <h2 class="home-title">Ideias em destaque</h2>

      <?php
      $list = DoloresHome::get_ideias();
      $query = new WP_Query(array(
        'orderby' => 'post__in',
        'post__in' => $list,
        'post_type' => 'ideia',
        'posts_per_page' => 3
      ));
      require_once("grid-ideias.php");
      dolores_grid_ideias($query, true);
      ?>

      <div class="home-button-container">
        <a class="home-button" href="/temas">Veja todos os temas</a>
      </div>
    </div>
  </section>

  <?php
  $flow1 = DoloresAssets::get_image_uri('home-flow-1.png');
  $flow2 = DoloresAssets::get_image_uri('home-flow-2.png');
  $flow3 = DoloresAssets::get_image_uri('home-flow-3.png');
  ?>

  <section class="home-flow">
    <div class="wrap">
      <ol class="flow-list">
        <li class="home-flow-item bg-pattern-light-purple">
          <a href="#" class="flow-link">
            <img class="flow-image" src="<?php echo $flow1; ?>" />
            <div class="flow-item-title-container">
              <h3 class="flow-item-title">
                Faça você mesmo
              </h3>
            </div>
          </a>
        </li>
        <li class="home-flow-item bg-pattern-orange">
          <a href="#" class="flow-link">
            <img class="flow-image" src="<?php echo $flow2; ?>" />
            <div class="flow-item-title-container">
              <h3 class="flow-item-title">
                Chegue junto<br />das atividades
              </h3>
            </div>
          </a>
        </li>
        <li class="home-flow-item bg-pattern-teal">
          <a href="#" class="flow-link">
            <img class="flow-image" src="<?php echo $flow3; ?>" />
            <div class="flow-item-title-container">
              <h3 class="flow-item-title">
                Participe:<br />seja voluntário
              </h3>
            </div>
          </a>
        </li>
      </ol>
    </section>
  </main>

  <?php
}

include(__DIR__ . '/grid.php');
?>

<?php
get_footer();
?>
