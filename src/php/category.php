<?php
get_header();
?>

<main class="page wrap">
  <h2 class="archive-title"><?php single_cat_title(); ?></h2>
</main>

<?php
include(__DIR__ . '/grid.php');
?>

<?php
get_footer();
?>
