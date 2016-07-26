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
        src="https://www.youtube.com/embed/_vUWfGD-1bQ?rel=0&amp;showinfo=0"
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
    <div class="hero-content">
      <div class="wrap">
        <div class="hero-left">
          <div class="hero-logo-container">
            <a href="<?php echo site_url(); ?>" title="Página inicial">
              <img class="hero-logo-image" src="<?php echo $logo_src; ?>" />
            </a>
          </div>
          <button class="hero-button toggle-explanation">
            Entenda
          </button>
        </div>
        <div class="hero-right">
          <p class="hero-call">
            <strong>Há um ano, mais de cinco mil pessoas vêm pensando em soluções para os problemas que enfrentamos todos os dias no Rio.</strong> Foram mais  de 60 encontros em 16 regiões da cidade.
          </p>

          <p class="hero-call">
            <strong>Agora precisamos fazer essas ideias virarem realidade.</strong> Cadastre-se e receba os chamados para participar da mobilização no seu bairro:
          </p>

          <form class="hero-form">
            <div class="hero-form-item">
              <label for="hero-email" class="hero-label">E-mail</label>
              <input
                class="hero-form-input"
                type="text"
                name="email"
                id="hero-email"
                placeholder="E-mail"
                />
            </div>
            <div class="hero-form-item">
              <label for="hero-phone" class="hero-label">Telefone</label>
              <input
                class="hero-form-input"
                type="text"
                name="phone"
                id="hero-phone"
                placeholder="Telefone"
                />
            </div>
            <div class="hero-form-item">
              <label for="hero-location" class="hero-label">Bairro</label>
              <input
                class="hero-form-input"
                type="text"
                name="location"
                id="hero-location"
                placeholder="Bairro"
                />
            </div>
            <div class="hero-form-item">
              <input type="hidden" name="origin" value="Home" />
              <button class="hero-form-button" type="submit">
                Quero
              </button>
            </div>
            <div class="hero-form-response"></div>
          </form>
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

  <h2 class="home-gray-title">Participe</h2>

  <main class="grid-temas">
    <div class="wrap">
      <ul class="grid-temas-list">
        <?php
        $items = array(
          array(
            "slug" => "proponha",
            "text" => "Proponha e discuta ideias",
            "link" => "/temas/"
          ),
          array(
            "slug" => "participe",
            "text" => "Participe e organize encontros",
            "link" => "/calendario/"
          ),
          array(
            "slug" => "organize",
            "text" => "Proponha mudanças no seu bairro",
            "link" => "/organize-um-encontro-do-se-a-cidade-fosse-nossa-no-seu-bairro/"
          ),
          array(
            "slug" => "colabore",
            "text" => "Colabore com a comunicação",
            "link" => "https://docs.google.com/forms/d/1GN2dXM-Bz-i11i8UH2Gnh82Heh1tJfEHWUSHtM_VLS4/viewform"
          )
        );
        foreach ($items as $item) {
          $bg = "scfn/home-{$item['slug']}.jpg";
          $icon = "scfn/home-icon-{$item['slug']}.png";

          $bg = "url('" . DoloresAssets::get_image_uri($bg) . "')";
          $icon = DoloresAssets::get_image_uri($icon);
          ?>
          <li class="grid-tema" style="background-image: <?php echo $bg; ?>;">
            <a class="grid-tema-link" href="<?php echo $item['link']; ?>">
              <div class="grid-tema-wrap">
                <img class="home-participe-icon" src="<?php echo $icon; ?>" />
                <h3 class="home-participe-text">
                  <?php echo $item['text']; ?>
                </h3>
              </div>
            </a>
          </li>
          <?php
        }
        ?>
      </ul>
    </div>
  </main>

  <h2 class="home-gray-title">Notícias</h2>

  <?php dolores_grid(); ?>

  <h2 class="home-gray-title">Apoios</h2>

  <section class="home-row">
    <div class="wrap">
      <div class="home-col">
        <?php
        $query = new WP_Query(array(
          'category_name' => 'apoios',
          'orderby' => 'rand',
          'posts_per_page' => 5
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
            <h4 class="home-action-label"><span>Quem apoia?</span></h4>
            <h2 class="home-action-title no-button">
              <?php the_title(); ?>
            </h2>
          </a>
        </div>
      </div>
      <div class="home-col grid-2">
        <?php
        dolores_grid($query);
        ?>
      </div>
    </div>
  </section>

  <section class="site-grid home-grid-negative-margin">
    <div class="wrap">
      <ul></ul>
      <div class="grid-ideias-pagination">
        <a class="grid-ideias-button" href="/secoes/apoios">
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
