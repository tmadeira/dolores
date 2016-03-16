<?php
get_header();
?>

<main class="wrap default-wrap no-padding-bottom">
  <h2 class="archive-title">Notícias</h2>
</main>

<?php
global $query_string;
$cats = array();
foreach (array('contribuicoes', 'projetos-na-camara') as $slug) {
  $cats[] = '-' . get_category_by_slug($slug)->term_id;
}
query_posts($query_string . '&cat=' . implode(',', $cats));
dolores_grid();
?>

<?php
get_footer();
?>
