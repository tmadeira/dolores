<?php
the_post();
get_header();
?>

<main class="wrap default-wrap">
  <?php require(DOLORES_TEMPLATE_PATH . '/bairros-map.php'); ?>
</main>

<?php
get_footer();
?>
