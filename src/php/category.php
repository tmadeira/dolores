<?php
get_header();
?>

<main class="page wrap">
  <h2 class="archive-title"><?php single_cat_title(); ?></h2>
</main>

<?php
require_once(__DIR__ . '/grid.php');
dolores_grid();
?>

<?php
get_footer();
?>
