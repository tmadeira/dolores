<?php
if ($_GET['ajax']) {
  dolores_grid();
  die();
}

require_once(DOLORES_PATH . '/dlib/assets.php');
require_once(DOLORES_PATH . '/dlib/wp_util/add_paged_class.php');
require_once(DOLORES_PATH . '/dlib/wp_admin/settings/home.php');
require_once(DOLORES_PATH . '/dlib/wp_admin/settings/streaming.php');

get_header();

global $wp_query;

$logo_src = DoloresAssets::get_image_uri('scfn/logo.png');

$video_mp4 = DoloresAssets::get_static_uri('videos/scfn/futebol.mp4');
$video_webm = DoloresAssets::get_static_uri('videos/scfn/futebol.webm');
$hero_src = DoloresAssets::get_image_uri('scfn/hero-futebol.jpg');

if (!$paged || $paged == 1) {
  ?>
  <section class="site-presentation explanation">
    <div class="wrap explanation-wrap">
      <iframe
        width="853"
        height="480"
        src="https://www.youtube.com/embed/XTXlM-F4zpQ?rel=0&amp;showinfo=0"
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

  <section class="home-ideas">
    <div class="wrap">
      <h2 class="home-title">Você tem ideias para a cidade?</h2>

      <?php
      $list = DoloresHome::get_ideias();
      $query = new WP_Query(array(
        'orderby' => 'post__in',
        'post__in' => $list,
        'post_type' => 'ideia',
        'posts_per_page' => 3
      ));
      dolores_grid_ideias($query, true);
      ?>

      <div class="home-button-container">
        <a class="home-button" href="/temas">Veja todos os temas e participe</a>
      </div>
    </div>
  </section>

  <section class="home-row">
    <div class="wrap">
      <div class="home-col grid-2">
        <?php
        $args = array_merge($wp_query->query_vars, array(
          'posts_per_page' => 4
        ));
        $query = new WP_Query($args);
        dolores_grid($query);
        ?>
      </div>
      <div class="home-col">
        <?php
        $query = new WP_Query(array(
          'category_name' => 'acoes'
        ));
        $query->the_post();
        list($img_src) = wp_get_attachment_image_src(
          get_post_thumbnail_id($post->ID),
          'bigger'
        );
        $style = "style=\"background-image:url('$img_src');\"";
        ?>
        <div class="home-col-wrap"<?php echo $style; ?>>
          <a class="home-main-item-link" href="<?php the_permalink(); ?>">
            <h4 class="home-action-label">Ação</h4>
            <h2 class="home-action-title">
              <?php the_title(); ?>
            </h2>
            <button class="home-action-button home-main-item-action">
              Vem junto!
            </button>
          </a>
        </div>
      </div>
    </div>
  </section>

  <?php
  $flow1 = DoloresAssets::get_image_uri('scfn/home-flow-1.png');
  $flow2 = DoloresAssets::get_image_uri('scfn/home-flow-2.png');
  $flow3 = DoloresAssets::get_image_uri('scfn/home-flow-3.png');
  ?>

  <section class="home-flow">
    <div class="wrap">
      <ol class="flow-list">
        <li class="home-flow-item bg-pattern-light-purple">
          <a href="/baixe-nossos-materiais" class="flow-link">
            <img class="flow-image" src="<?php echo $flow1; ?>" />
            <div class="flow-item-title-container">
              <h3 class="flow-item-title">
                Baixe nossos materiais
              </h3>
            </div>
          </a>
        </li>
        <li class="home-flow-item bg-pattern-orange">
          <a href="/calendario" class="flow-link">
            <img class="flow-image" src="<?php echo $flow2; ?>" />
            <div class="flow-item-title-container">
              <h3 class="flow-item-title">
                Chegue junto<br />das atividades
              </h3>
            </div>
          </a>
        </li>
        <li class="home-flow-item bg-pattern-teal">
          <a href="/participe" class="flow-link">
            <img class="flow-image" src="<?php echo $flow3; ?>" />
            <div class="flow-item-title-container">
              <h3 class="flow-item-title">
                Colabore
              </h3>
            </div>
          </a>
        </li>
      </ol>
    </div>
  </section>

  <section class="home-row">
    <div class="wrap">
      <div class="home-col">
        <?php
        $query = new WP_Query(array(
          'category_name' => 'apoios',
          'orderby' => 'rand'
        ));
        $query->the_post();
        list($img_src) = wp_get_attachment_image_src(
          get_post_thumbnail_id($post->ID),
          'bigger'
        );
        $style = "style=\"background-image:url('$img_src');\"";
        ?>
        <div class="home-col-wrap"<?php echo $style; ?>>
          <a class="home-main-item-link" href="/secoes/apoios/">
            <h4 class="home-action-label">Quem apoia?</h4>
            <h2 class="home-action-title no-button">
              <?php the_title(); ?>
            </h2>
          </a>
        </div>
      </div>
      <div class="home-col grid-2">
        <?php
        $args = array_merge($wp_query->query_vars, array(
          'posts_per_page' => 4,
          'paged' => 2
        ));
        $query = new WP_Query($args);
        dolores_grid($query);
        ?>
      </div>
    </div>
  </section>

  <section class="site-grid home-grid-negative-margin">
    <div class="wrap">
      <ul></ul>
      <div class="grid-ideias-pagination">
        <a class="grid-ideias-button ajax-load-more" href="/page/2">
          Ver mais
        </a>
      </div>
    </div>
  </section>

  <?php

} else {
  dolores_grid();
}
?>

<?php
get_footer();
?>
