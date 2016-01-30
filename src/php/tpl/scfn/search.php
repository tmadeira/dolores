<?php
get_header();
?>

<main class="page wrap">
  <h2 class="archive-title">
    Busca por &laquo;<?php echo esc_html($_GET['s']); ?>&raquo;
  </h2>
</main>

<?php
if (!array_key_exists('post_type', $_GET) || $_GET['post_type'] == 'post') {
  ?>
  <h2 class="author-grid-title">Posts</h2>

  <?php
  $query = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 8,
    'paged' => intval($_GET['page']),
    's' => $_GET['s']
  ));
  dolores_grid($query);
}
?>

<?php
if (!array_key_exists('post_type', $_GET) || $_GET['post_type'] == 'ideia') {
  ?>
  <h2 class="author-grid-title">Ideias</h2>

  <?php
  $query = new WP_Query(array(
    'post_type' => 'ideia',
    'posts_per_page' => 6,
    'paged' => intval($_GET['page']),
    's' => $_GET['s']
  ));
  dolores_grid_ideias($query);
}
?>

<?php
get_footer();
?>
