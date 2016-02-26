<?php
if (have_posts()) {
  ?>
  <ol class="related-list">
    <?php
    while (have_posts()) {
      the_post();
      $cats = get_the_category();
      if (count($cats) > 0) {
        $cat = $cats[0]->cat_name;
      }
      ?>
      <li class="related-item">
        <a class="related-link" href="<?php the_permalink() ?>" rel="bookmark">
          <span class="related-cat"><?php echo $cat; ?></span>
          <span class="related-title"><?php the_title(); ?></span>
        </a>
      </li>
      <?php
    }
    ?>
  </ol>
  <?php
}
?>
