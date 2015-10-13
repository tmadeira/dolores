<?php
function dolores_grid($query = null) {
  global $wp_query;
  if ($query === null) {
    $query = $wp_query;
  }
  ?>
  <section class="site-grid">
    <div class="wrap">
      <?php
      if ($query->have_posts()) {
        echo '<ul>';
        while ($query->have_posts()) {
          $query->the_post();
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
      } else {
        echo '<p>Nenhum post para mostrar.</p>';
      }

      if ($query->is_main_query()) {
        if (!$paged) {
          $paged = 1;
        }

        $prev_page = intval($paged) - 1;
        $next_page = intval($paged) + 1;

        ?>
        <div class="grid-pagination">
          <?php

          if ($prev_page > 0) {
            $prev_link = get_previous_posts_page_link();
            ?>
            <a class="btn-prev-page" href="<?php echo $prev_link; ?>"></a>
            <?php
          }

          if ($next_page <= $query->max_num_pages) {
            $next_link = get_next_posts_page_link();
            ?>
            <a class="btn-next-page" href="<?php echo $next_link; ?>"></a>
            <?php
          }
          ?>
        </div>
      <?php
      }
      ?>
    </div>
  </section>
<?php
}
?>
