<section class="site-grid">
  <div class="wrap">
    <?php
    if (have_posts()) {
      echo '<ul>';
      while (have_posts()) {
        the_post();
        list($img_src) = wp_get_attachment_image_src(
          get_post_thumbnail_id($post->ID),
          'post-thumbnail'
        );
        $style = "background-image: url('$img_src');";
        ?>
        <li class="grid-post" style="<?php echo $style; ?>">
          <a href="<?php the_permalink(); ?>">
            <h3><?php the_title(); ?></h3>
          </a>
        </li>
        <?php
      }
      echo '</ul>';
    }
    ?>
  </div>
</section>
