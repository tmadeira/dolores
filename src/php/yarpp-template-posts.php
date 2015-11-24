<?php
/*
YARPP Template: Dolores (Posts)
Author: Tiago Madeira
Description: Template do YARPP para mostrar posts relacionados
*/
if (have_posts()) {
  ?>
  <ol class="yarpp-list">
    <?php
    while (have_posts()) {
      the_post();
      ?>
      <li class="yarpp-item">
        <a class="yarpp-link" href="<?php the_permalink() ?>" rel="bookmark">
          <?php the_title(); ?>
        </a><br />
        <span class="yarpp-date">
          <?php the_time('d/M/Y'); ?>
        </span>
      </li>
      <?php
    }
    ?>
  </ol>
  <?php
}
?>
