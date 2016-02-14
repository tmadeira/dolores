<?php
the_post();
$base = get_permalink();

function dolores_bairros_grid() {
  global $wp_query, $base;
  $paged = intval(preg_replace('/[^0-9]*/', '', $wp_query->query['page']));
  $paged = max($paged, 1);

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
      <?php dolores_print_share_buttons(); ?>
    </div>

    <div class="entry">
      <?php the_content(); ?>
    </div>
  </article>

  <?php get_sidebar(); ?>
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
