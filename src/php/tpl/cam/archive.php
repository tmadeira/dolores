<?php
add_filter('get_the_archive_title', function($title) {
  if (is_category()) {
    $title = single_cat_title();
  }
  return $title;
});

get_header();
?>

<main class="wrap default-wrap no-padding-bottom">
  <h2 class="archive-title"><?php the_archive_title(); ?></h2>
</main>

<?php
dolores_grid();
?>

<?php
get_footer();
?>
