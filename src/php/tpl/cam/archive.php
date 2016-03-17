<?php
$display_type = 'grid';
add_filter('get_the_archive_title', function($title) {
  global $display_type;
  if (is_category()) {
    $title = single_cat_title('', false);
  }
  switch ($title) {
  case 'Contribuições':
    $title = 'Contribuições para o debate';
    $display_type = 'list';
    break;
  case 'Projetos na câmara':
    $title = 'Conheça nossos projetos na câmara municipal';
    $display_type = 'content';
    break;
  }
  return $title;
});

get_header();
?>

<main class="wrap default-wrap no-padding-bottom">
  <h2 class="archive-title"><?php the_archive_title(); ?></h2>
  <?php
  if (is_category() && category_description()) {
    ?>
    <div class="archive-description">
      <?php echo category_description(); ?>
    </div>
    <?php
  }
  ?>
</main>

<?php
global $query_string;
switch ($display_type) {
case 'list':
  query_posts($query_string . '&posts_per_page=-1');
  dolores_list();
  break;
case 'content':
  query_posts($query_string . '&posts_per_page=-1');
  dolores_list_content();
  break;
default:
  dolores_grid();
}
?>

<?php
get_footer();
?>
