<?php
/*
YARPP Template: Dolores (Ideias)
Author: Tiago Madeira
Description: Template do YARPP para mostrar posts relacionados
*/
// TODO: improve template
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
        </a>
      </li>
      <?php
    }
    ?>
  </ol>
  <?php
}
?>
