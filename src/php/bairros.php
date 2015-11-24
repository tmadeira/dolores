<?php
/* Template Name: Bairros */

the_post();
$base = get_permalink();

function dolores_bairros_grid() {
  global $wp_query, $base;
  $paged = intval(preg_replace('/[^0-9]*/', '', $wp_query->query['page']));
  $paged = max($paged, 1);

  require_once(__DIR__ . '/grid.php');
  $query = new WP_Query(array(
    'category_name' => 'encontros-nos-bairros',
    'paged' => $paged
  ));
  dolores_grid($query, $base);
}

if ($_GET['ajax']) {
  dolores_temas_grid();
  die();
}

get_header();
?>
<main class="page wrap">
  <article class="single-content">
    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="single-meta social-media">
      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-lang="pt"></a>
    </div>

    <div class="entry">
      <?php the_content(); ?>
    </div>
  </article>
</main>

<section class="temas-posts">
  <div class="wrap">
    <h2 class="temas-posts-title">
      <span>Encontros de bairros que já rolaram</span>
    </h2>

    <?php
    dolores_bairros_grid();
    ?>
  </div>
</section>

<?php
get_footer();
?>